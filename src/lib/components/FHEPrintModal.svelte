<script>
	import { PDFDocument } from "pdf-lib";
	import { createEventDispatcher } from "svelte";
	export let show = false;
	export let formData = {};
	export let pdfUrl = "";
	const dispatch = createEventDispatcher();

	let filledPdfUrl = "";
	let loading = false;
	let error = "";

	async function fillAndPrintPDF() {
		loading = true;
		error = "";
		try {
			const existingPdfBytes = await fetch(pdfUrl).then((res) => res.arrayBuffer());
			const pdfDoc = await PDFDocument.load(existingPdfBytes);
			const page = pdfDoc.getPages()[0];

			page.drawText(formData.date_of_application || "", { x: 175, y: 705, size: 12 });
			page.drawText(formData.fullname || "", { x: 115, y: 619, size: 12 });
			page.drawText(formData.id || "", { x: 446, y: 619, size: 12 });
			page.drawText(formData.address || "", { x: 200, y: 608, size: 10 });
			formData.sex === "Male" ? page.drawText("X", { x: 138, y: 595, size: 9 }) : page.drawText("X", { x: 210, y: 595, size: 9 });
			formData.civil_status === "Single" ? page.drawText("X", { x: 390.2, y: 595, size: 9 }) : page.drawText("X", { x: 458.7, y: 595, size: 9 });
			page.drawText(formData.phone || "", { x: 163, y: 585, size: 11 });
			page.drawText(formData.email || "", { x: 388, y: 585, size: 10 });
			page.drawText(formData.course || "", { x: 123, y: 572, size: 11 });
			page.drawText(formData.year_level || "", { x: 454, y: 572, size: 11 });

			if (formData.type_student && formData.type_student.includes("New")) {
				page.drawText("X", { x: 174.2, y: 549, size: 9 });
				page.drawText(formData.school_name_last_attended, { x: 303, y: 537, size: 10 });
				page.drawText(formData.year_last_attended, { x: 215, y: 527, size: 10 });
			}
			if (formData.type_student && formData.type_student.includes("Continuing")) {
				page.drawText("X", { x: 282, y: 549, size: 9 });
			}
			if (formData.type_student && formData.type_student.includes("Returning")) {
				page.drawText("X", { x: 426.2, y: 549, size: 9 });
			}

			if (formData.scholarship === "Yes") {
				page.drawText("X", { x: 318, y: 504, size: 9 });
				page.drawText(formData.scholarship_name || "", { x: 83, y: 482, size: 10 });
			} else {
				page.drawText("X", { x: 426, y: 504, size: 9 });
			}

			page.drawText(formData.father_name || "", { x: 125, y: 425, size: 10 });
			page.drawText(formData.father_occupation || "", { x: 343, y: 425, size: 10 });
			page.drawText(String(formData.father_income ?? ""), { x: 447, y: 425, size: 10 });
			page.drawText(formData.mother_name || "", { x: 125, y: 412.8, size: 10 });
			page.drawText(formData.mother_occupation || "", { x: 343, y: 412.8, size: 10 });
			page.drawText(String(formData.mother_income ?? ""), { x: 447, y: 412.8, size: 10 });
			page.drawText(String(formData.total_income ?? ""), { x: 447, y: 400, size: 10 });

			// Draw student signature if available
			if (formData.studentsignatureData) {
				try {
					const signatureImageBytes = await fetch(formData.studentsignatureData).then((res) => res.arrayBuffer());
					const signatureImage = await pdfDoc.embedPng(signatureImageBytes);
					page.drawImage(signatureImage, {
						x: 100,
						y: 330,
						width: 100,
						height: 30,
					});
				} catch (e) {
					// ignore signature errors for print
				}
			}
			page.drawText(formData.fullname || "", { x: 90, y: 320, size: 12 });

			// Draw guardian signature if available
			if (formData.guardianSignatureData) {
				try {
					const guardianImageBytes = await fetch(formData.guardianSignatureData).then((res) => res.arrayBuffer());
					const guardianImage = await pdfDoc.embedPng(guardianImageBytes);
					page.drawImage(guardianImage, {
						x: 350,
						y: 330,
						width: 100,
						height: 30,
					});
				} catch (e) {
					// ignore signature errors for print
				}
			}
			page.drawText(formData.guardian_name || "", { x: 380, y: 320, size: 12 });

			// Draw student picture if available
			if (formData.student_picture) {
				let imageUrl = "";
				if (typeof formData.student_picture === "string" && formData.student_picture.startsWith("data:image")) {
					imageUrl = formData.student_picture;
				} else if (formData.student_picture_preview && formData.student_picture_preview.startsWith("data:image")) {
					imageUrl = formData.student_picture_preview;
				}
				if (imageUrl) {
					try {
						const pictureBytes = await fetch(imageUrl).then((res) => res.arrayBuffer());
						let pictureImage;
						let embedded = false;
						// Try PNG first
						try {
							pictureImage = await pdfDoc.embedPng(pictureBytes);
							embedded = true;
						} catch (e) {
							// Try JPG if PNG fails
						}
						if (!embedded) {
							try {
								pictureImage = await pdfDoc.embedJpg(pictureBytes);
								embedded = true;
							} catch (e) {
								// ignore image errors for print
							}
						}
						if (embedded) {
							page.drawImage(pictureImage, {
								x: 425,
								y: 691,
								width: 135,
								height: 135,
							});
						}
					} catch (e) {
						// ignore image errors for print
					}
				}
			}

			const pdfBytes = await pdfDoc.save();
			filledPdfUrl = URL.createObjectURL(new Blob([pdfBytes], { type: "application/pdf" }));
		} catch (e) {
			error = "Failed to generate PDF.";
		}
		loading = false;
	}

	$: if (show) fillAndPrintPDF();

	function close() {
		dispatch("close");
		filledPdfUrl = "";
	}
</script>

{#if show}
	<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
		<div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl w-full relative">
			<button class="absolute top-2 right-2 text-white bg-red-600 border-2 border-red-800 rounded-full w-12 h-12 flex items-center justify-center text-3xl font-bold shadow-lg hover:bg-red-700 hover:border-red-900 transition focus:outline-none focus:ring-2 focus:ring-red-400" on:click={close} aria-label="Close">&times;</button>
			<h2 class="text-xl font-bold mb-4">Print or Download PDF</h2>
			{#if loading}
				<div>Generating PDF...</div>
			{:else if error}
				<div class="text-red-600">{error}</div>
			{:else if filledPdfUrl}
				<iframe src={filledPdfUrl} title="PDF Print Preview" class="w-full h-[80vh] min-h-[600px] border rounded mb-4 mt-4"></iframe>
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
