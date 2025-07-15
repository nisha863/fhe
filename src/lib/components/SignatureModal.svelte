<script>
	// @ts-nocheck
	import { createEventDispatcher, onMount } from "svelte";
	import { browser } from "$app/environment";

	export let show = false;
	export let value = "";
	export let label = "Signature";
	const dispatch = createEventDispatcher();

	let canvas;
	let signaturePad;
	let signatureData = value;
	let isSaved = !!value;

	onMount(async () => {
		if (browser && canvas) {
			// Dynamically import SignaturePad only on the client side
			const { default: SignaturePad } = await import("signature_pad");

			signaturePad = new SignaturePad(canvas);
			if (signatureData) {
				const img = new window.Image();
				img.onload = () => {
					signaturePad.clear();
					const ctx = canvas.getContext("2d");
					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
				};
				img.src = signatureData;
			}
		}
	});

	// Only initialize when modal first shows
	$: if (show && canvas && browser && !signaturePad) {
		import("signature_pad").then(({ default: SignaturePad }) => {
			signaturePad = new SignaturePad(canvas);
			if (value && isSaved) {
				const img = new window.Image();
				img.onload = () => {
					signaturePad.clear();
					const ctx = canvas.getContext("2d");
					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
				};
				img.src = value;
			}
		});
	}

	function clearSignature() {
		if (signaturePad) {
			signaturePad.clear();
		}
		signatureData = "";
		isSaved = false;
	}

	function saveSignature() {
		if (signaturePad && !signaturePad.isEmpty()) {
			signatureData = signaturePad.toDataURL();
			isSaved = true;
			dispatch("save", { data: signatureData });
		}
	}

	function editSignature() {
		isSaved = false;
		if (signaturePad) {
			signaturePad.clear();
		}
		signatureData = "";
	}

	function close() {
		// Clean up the SignaturePad instance when closing
		if (signaturePad) {
			signaturePad.off(); // Remove event listeners
			signaturePad = null;
		}
		dispatch("close");
	}
</script>

{#if show}
	<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
		<div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full relative">
			<button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" on:click={close}>&times;</button>
			<h2 class="text-xl font-bold mb-4">{label}</h2>
			<canvas bind:this={canvas} width="400" height="120" class="border rounded bg-white block mx-auto mb-4"></canvas>
			<div class="flex gap-2 justify-center">
				<button type="button" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400" on:click={clearSignature}>Clear</button>
				{#if !isSaved}
					<button type="button" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" on:click={saveSignature}>Save</button>
				{:else}
					<button type="button" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700" on:click={editSignature}
						>Edit Signature</button
					>
				{/if}
			</div>
		</div>
	</div>
{/if}
