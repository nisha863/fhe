<script>
	import { PDFDocument } from "pdf-lib";
	import { createEventDispatcher, onDestroy, onMount } from "svelte";
	export let show = false;
	export let students = [];
	export let pdfUrl = "";
	const dispatch = createEventDispatcher();

	let filledPdfUrl = "";
	let loading = false;
	let error = "";

	function safe(val, fallback = "") {
		return val == null ? fallback : val;
	}

	async function fetchImageAsBytes(url) {
		if (!url) return null;
		try {
			// If already a data URL, convert to bytes
			if (url.startsWith("data:image")) {
				const base64 = url.split(",")[1];
				return Uint8Array.from(atob(base64), (c) => c.charCodeAt(0));
			}
			// Otherwise, fetch as blob
			const res = await fetch(url);
			if (!res.ok) return null;
			return new Uint8Array(await res.arrayBuffer());
		} catch (e) {
			return null;
		}
	}

	async function fillAndPreviewPDFs() {
		loading = true;
		error = "";
		try {
			const existingPdfBytes = await fetch(pdfUrl).then((res) => res.arrayBuffer());
			const pdfDoc = await PDFDocument.create();
			for (const formDataRaw of students) {
				const formData = {
					...formDataRaw,
					type_student: safe(formDataRaw.type_student, ""),
					school_name_last_attended: safe(formDataRaw.school_name_last_attended),
					year_last_attended: safe(formDataRaw.year_last_attended),
					scholarship: safe(formDataRaw.scholarship),
					scholarship_name: safe(formDataRaw.scholarship_name),
					mother_name: safe(formDataRaw.mother_name),
					father_name: safe(formDataRaw.father_name),
					mother_occupation: safe(formDataRaw.mother_occupation),
					father_occupation: safe(formDataRaw.father_occupation),
					mother_income: safe(formDataRaw.mother_income),
					father_income: safe(formDataRaw.father_income),
					total_income: safe(formDataRaw.total_income),
					studentsignatureData: safe(formDataRaw.studentsignatureData),
					guardianSignatureData: safe(formDataRaw.guardianSignatureData),
					student_picture: safe(formDataRaw.student_picture),
					student_picture_preview: safe(formDataRaw.student_picture_preview),
					date_of_application: safe(formDataRaw.date_of_application),
					fullname: safe(formDataRaw.fullname),
					id: safe(formDataRaw.id),
					address: safe(formDataRaw.address),
					sex: safe(formDataRaw.sex),
					civil_status: safe(formDataRaw.civil_status),
					phone: safe(formDataRaw.phone),
					email: safe(formDataRaw.email),
					course: safe(formDataRaw.course),
					year_level: safe(formDataRaw.year_level),
					guardian_name: safe(formDataRaw.guardian_name),
					guardian_relationship: safe(formDataRaw.guardian_relationship),
				};
				const srcPdf = await PDFDocument.load(existingPdfBytes);
				const [srcPage] = await pdfDoc.copyPages(srcPdf, [0]);
				const page = srcPage;
				page.drawText(String(formData.date_of_application), { x: 175, y: 705, size: 12 });
				page.drawText(String(formData.fullname), { x: 115, y: 619, size: 12 });
				page.drawText(String(formData.id_number), { x: 446, y: 619, size: 12 });
				page.drawText(String(formData.address), { x: 200, y: 608, size: 10 });
				formData.sex === "Male" ? page.drawText("X", { x: 138, y: 595, size: 9 }) : page.drawText("X", { x: 210, y: 595, size: 9 });
				formData.civil_status === "Single"
					? page.drawText("X", { x: 390.2, y: 595, size: 9 })
					: page.drawText("X", { x: 458.7, y: 595, size: 9 });
				page.drawText(String(formData.phone), { x: 163, y: 585, size: 11 });
				page.drawText(String(formData.email), { x: 388, y: 585, size: 10 });
				page.drawText(String(formData.course), { x: 123, y: 572, size: 11 });
				page.drawText(String(formData.year_level), { x: 454, y: 572, size: 11 });
				if ((formData.type_student || "").includes("New")) {
					page.drawText("X", { x: 174.2, y: 549, size: 9 });
					page.drawText(String(formData.school_name_last_attended), { x: 303, y: 537, size: 10 });
					page.drawText(String(formData.year_last_attended), { x: 215, y: 527, size: 10 });
				}
				if ((formData.type_student || "").includes("Continuing")) {
					page.drawText("X", { x: 282, y: 549, size: 9 });
				}
				if ((formData.type_student || "").includes("Returning")) {
					page.drawText("X", { x: 426.2, y: 549, size: 9 });
				}
				if (formData.scholarship === "Yes") {
					page.drawText("X", { x: 318, y: 504, size: 9 });
					page.drawText(String(formData.scholarship_name), { x: 83, y: 482, size: 10 });
				} else {
					page.drawText("X", { x: 426, y: 504, size: 9 });
				}
				page.drawText(String(formData.father_name), { x: 125, y: 425, size: 10 });
				page.drawText(String(formData.father_occupation), { x: 343, y: 425, size: 10 });
				page.drawText(String(formData.father_income), { x: 447, y: 425, size: 10 });
				page.drawText(String(formData.mother_name), { x: 125, y: 412.8, size: 10 });
				page.drawText(String(formData.mother_occupation), { x: 343, y: 412.8, size: 10 });
				page.drawText(String(formData.mother_income), { x: 447, y: 412.8, size: 10 });
				page.drawText(String(formData.total_income), { x: 447, y: 400, size: 10 });
				// Student signature
				if (formData.student_signature) {
					const signatureBytes = await fetchImageAsBytes(formData.student_signature);
					if (signatureBytes) {
						try {
							const signatureImage = await pdfDoc.embedPng(signatureBytes);
							page.drawImage(signatureImage, {
								x: 100,
								y: 330,
								width: 100,
								height: 30,
							});
						} catch (e) {}
					}
				}
				page.drawText(String(formData.fullname), { x: 90, y: 320, size: 12 });
				// Guardian signature
				if (formData.guardian_signature) {
					const guardianBytes = await fetchImageAsBytes(formData.guardian_signature);
					if (guardianBytes) {
						try {
							const guardianImage = await pdfDoc.embedPng(guardianBytes);
							page.drawImage(guardianImage, {
								x: 350,
								y: 330,
								width: 100,
								height: 30,
							});
						} catch (e) {}
					}
				}
				page.drawText(String(formData.guardian_name), { x: 380, y: 320, size: 12 });
				// Student picture
				if (formData.student_picture) {
					const pictureBytes = await fetchImageAsBytes(formData.student_picture);
					if (pictureBytes) {
						let pictureImage;
						let embedded = false;
						try {
							pictureImage = await pdfDoc.embedPng(pictureBytes);
							embedded = true;
						} catch (e) {}
						if (!embedded) {
							try {
								pictureImage = await pdfDoc.embedJpg(pictureBytes);
								embedded = true;
							} catch (e) {}
						}
						if (embedded) {
							page.drawImage(pictureImage, {
								x: 425,
								y: 691,
								width: 135,
								height: 135,
							});
						}
					}
				}
				pdfDoc.addPage(page);
			}
			const pdfBytes = await pdfDoc.save();
			filledPdfUrl = URL.createObjectURL(new Blob([pdfBytes], { type: "application/pdf" }));
		} catch (e) {
			error = "Failed to generate PDF: " + (e?.message || e);
			console.error("BulkPrint PDF error:", e);
		}
		loading = false;
	}

	$: if (show) fillAndPreviewPDFs();

	function close() {
		dispatch("close");
		filledPdfUrl = "";
	}

	onMount(() => {
		function handleKeydown(e) {
			if (e.key === "Escape") {
				close();
			}
		}
		window.addEventListener("keydown", handleKeydown);
		onDestroy(() => {
			window.removeEventListener("keydown", handleKeydown);
		});
	});
</script>

{#if show}
	<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
		<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl w-full relative">
			<button
				class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 p-3 border rounded-full bg-gray-100 hover:bg-gray-200"
				on:click={close}>&times;</button
			>
			<h2 class="text-xl font-bold mb-4">PDF Preview (Bulk)</h2>

			{#if loading}
				<div>Loading PDF...</div>
			{:else if error}
				<div class="text-red-600">{error}</div>
			{:else if filledPdfUrl}
				<iframe src={filledPdfUrl} title="PDF Preview" class="w-full h-[80vh] min-h-[600px] border rounded mb-4"></iframe>
			{/if}
		</div>
	</div>
{/if}

<style>
	.h-\[80vh\] {
		height: 80vh;
	}
	.min-h-\[600px\] {
		min-height: 600px;
	}
</style>
