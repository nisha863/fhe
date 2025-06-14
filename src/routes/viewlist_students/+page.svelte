<script>
	import { onMount } from "svelte";
	import BulkPrint from "../../lib/components/BulkPrint.svelte";

	let students = [];
	let loading = true;
	let error = "";
	let selected = new Set();
	let showBulkPrint = false;
	let pdfUrl = "/form.pdf"; // adjust if needed
	let allSelected = false;

	onMount(async () => {
		try {
			const res = await fetch("/api");
			if (!res.ok) throw new Error("Failed to fetch students.");
			students = await res.json();
		} catch (e) {
			error = e.message;
		} finally {
			loading = false;
		}
	});

	function printPage() {
		window.print();
	}

	function toggleSelect(id) {
		const newSelected = new Set(selected);
		if (newSelected.has(id)) {
			newSelected.delete(id);
		} else {
			newSelected.add(id);
		}
		selected = newSelected;
	}

	function printSelected() {
		showBulkPrint = true;
	}

	function closeBulkPrint() {
		showBulkPrint = false;
	}

	function toggleSelectAll() {
		if (allSelected) {
			selected = new Set();
		} else {
			selected = new Set(students.map((s) => s.id));
		}
	}

	$: allSelected = students.length > 0 && students.every((s) => selected.has(s.id));
</script>

<h1 class="text-2xl font-bold mb-6 text-center">List of Students</h1>

{#if loading}
	<div class="text-center text-gray-600">Loading...</div>
{:else if error}
	<div class="text-center text-red-600">{error}</div>
{:else if students.length === 0}
	<div class="text-center text-gray-600">No students found.</div>
{:else}
	<div class="overflow-x-auto">
		<table class="min-w-full bg-white border border-gray-300 shadow rounded text-xs md:text-sm">
			<thead>
				<tr class="bg-blue-600 text-white">
					<th class="py-2 px-4 border text-center">
						<input type="checkbox" checked={allSelected} on:change={toggleSelectAll} />
					</th>
					<th class="py-2 px-4 border hidden">ID (hidden)</th>
					<th class="py-2 px-4 border">Full Name</th>
					<th class="py-2 px-4 border">ID Number</th>
					<th class="py-2 px-4 border">Address</th>
					<th class="py-2 px-4 border">Sex</th>
					<th class="py-2 px-4 border">Civil Status</th>
					<th class="py-2 px-4 border">Phone</th>
					<th class="py-2 px-4 border">Email</th>
					<th class="py-2 px-4 border">Course</th>
					<th class="py-2 px-4 border">Year Level</th>
					<th class="py-2 px-4 border">Type of Student</th>
					<th class="py-2 px-4 border">School Last Attended</th>
					<th class="py-2 px-4 border">Year Last Attended</th>
					<th class="py-2 px-4 border">Scholarship</th>
					<th class="py-2 px-4 border">Scholarship Name</th>
					<th class="py-2 px-4 border">Mother Name</th>
					<th class="py-2 px-4 border">Father Name</th>
					<th class="py-2 px-4 border">Mother Occupation</th>
					<th class="py-2 px-4 border">Father Occupation</th>
					<th class="py-2 px-4 border">Mother Income</th>
					<th class="py-2 px-4 border">Father Income</th>
					<th class="py-2 px-4 border">Guardian Name</th>
					<th class="py-2 px-4 border">Guardian Relationship</th>
					<th class="py-2 px-4 border">Date of Application</th>
				</tr>
			</thead>
			<tbody>
				{#each students as student}
					<tr class="hover:bg-gray-100">
						<td class="py-2 px-4 border text-center">
							<input type="checkbox" checked={selected.has(student.id)} on:change={() => toggleSelect(student.id)} />
						</td>
						<td class="py-2 px-4 border hidden">{student.id}</td>
						<td class="py-2 px-4 border">{student.fullname}</td>
						<td class="py-2 px-4 border">{student.id_number}</td>
						<td class="py-2 px-4 border">{student.address}</td>
						<td class="py-2 px-4 border">{student.sex}</td>
						<td class="py-2 px-4 border">{student.civil_status}</td>
						<td class="py-2 px-4 border">{student.phone}</td>
						<td class="py-2 px-4 border">{student.email}</td>
						<td class="py-2 px-4 border">{student.course}</td>
						<td class="py-2 px-4 border">{student.year_level}</td>
						<td class="py-2 px-4 border">{student.type_student}</td>
						<td class="py-2 px-4 border">{student.school_name_last_attended}</td>
						<td class="py-2 px-4 border">{student.year_last_attended}</td>
						<td class="py-2 px-4 border">{student.scholarship}</td>
						<td class="py-2 px-4 border">{student.scholarship_name}</td>
						<td class="py-2 px-4 border">{student.mother_name}</td>
						<td class="py-2 px-4 border">{student.father_name}</td>
						<td class="py-2 px-4 border">{student.mother_occupation}</td>
						<td class="py-2 px-4 border">{student.father_occupation}</td>
						<td class="py-2 px-4 border">{student.mother_income}</td>
						<td class="py-2 px-4 border">{student.father_income}</td>
						<td class="py-2 px-4 border">{student.guardian_name}</td>
						<td class="py-2 px-4 border">{student.guardian_relationship}</td>
						<td class="py-2 px-4 border">{student.date_of_application}</td>
					</tr>
				{/each}
			</tbody>
		</table>
	</div>
	<div class="flex flex-wrap gap-4 justify-end mt-6">
		<button on:click={printPage} class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"> Print List </button>
		<button
			on:click={printSelected}
			class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"
			disabled={selected.size === 0}
		>
			Print Selected
		</button>
	</div>
	{#if showBulkPrint}
		<BulkPrint show={showBulkPrint} students={students.filter((s) => selected.has(s.id))} {pdfUrl} on:close={closeBulkPrint} />
	{/if}
{/if}
