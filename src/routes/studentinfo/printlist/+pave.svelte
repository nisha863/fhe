<script>
	import { onMount } from "svelte";
	import SaveButton from "./components/a.svelte";

	let form = {
		date: "",
		name: "",
		id: "",
		address: "",
		sex: "",
		civil_status: "",
		contact_number: "",
		email: "",
		course: "",
		year_level: "",
		type_student: "",
		school_last_attended: "",
		school_year_last_attended: "",
		receipt: "",
		scholarship: "",
		father_name: "",
		father_occupation: "",
		father_income: "",
		mother_name: "",
		mother_occupation: "",
		mother_income: "",
		total_family_income: "",
	};
	let showOverlay = false;
	function printOfficialForm() {
		showOverlay = true;
		setTimeout(() => window.print(), 100);
		setTimeout(() => (showOverlay = false), 1000);
	}

	onMount(() => {
		if (!form.date) {
			const today = new Date();
			const yyyy = today.getFullYear();
			const mm = String(today.getMonth() + 1).padStart(2, "0");
			const dd = String(today.getDate()).padStart(2, "0");
			form.date = `${yyyy}-${mm}-${dd}`;
		}
		// Set default values for other fields for now
		if (!form.name) form.name = "Miranda, Kerwin Klyde F.";
		if (!form.id) form.id = "221-0972-3";
		if (!form.address) form.address = "San Nicolas, San Pablo City, Laguna";
		if (!form.sex) form.sex = "Male";
		if (!form.civil_status) form.civil_status = "Single";
		if (!form.contact_number) form.contact_number = "09608915275";
		if (!form.email) form.email = "wewkewin@gmail.com";
		if (!form.course) form.course = "Computer Science";
		if (!form.year_level) form.year_level = "1";
		if (!form.type_student) form.type_student = "New";
		if (!form.school_last_attended) form.school_last_attended = "San Pablo City Science High School";
		if (!form.school_year_last_attended) form.school_year_last_attended = "2022-2023";
		if (!form.receipt) form.receipt = "Yes";
		if (!form.scholarship) form.scholarship = "secret";
		if (!form.father_name) form.father_name = "Da Father Name";
		if (!form.father_occupation) form.father_occupation = "Porman ";
		if (!form.father_income) form.father_income = "5000";
		if (!form.mother_name) form.mother_name = "My moma Name";
		if (!form.mother_occupation) form.mother_occupation = "Tambay";
		if (!form.mother_income) form.mother_income = "4000";
		if (!form.total_family_income) {
			form.total_family_income = (parseFloat(form.father_income) + parseFloat(form.mother_income)).toString();
		}
	});

	function updateTotalFamilyIncome() {
		const father = parseFloat(form.father_income) || 0;
		const mother = parseFloat(form.mother_income) || 0;
		form.total_family_income = (father + mother).toString();
	}

	let saveStatus = "";
	let saveError = "";

	async function saveToDatabase() {
		try {
			const response = await fetch("http://localhost/save_form.php", {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
				},
				body: JSON.stringify(form),
			});

			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}

			const result = await response.json();

			if (result.success) {
				saveStatus = "success";
				setTimeout(() => (saveStatus = ""), 3000);
			} else {
				saveStatus = "error";
				saveError = result.error || "Unknown error";
				setTimeout(() => (saveStatus = ""), 5000);
			}
		} catch (error) {
			saveStatus = "error";
			saveError = `Connection error: ${error.message}`;
			setTimeout(() => (saveStatus = ""), 5000);
		}
	}
</script>

{#if showOverlay}
	<div class="print-page" style="display:block !important;">
		<img src="form.png" alt="Official Form" class="form-bg" />
		<div class="overlay date">{form.date}</div>
		<div class="overlay name">{form.name}</div>
		<div class="overlay id">{form.id}</div>
		<div class="overlay address">{form.address}</div>
		<div class="overlay course">{form.course}</div>
		<div class="overlay year">{form.year_level}</div>
		<div class="overlay sex-male">{form.sex === "Male" ? "✔" : ""}</div>
		<div class="overlay sex-female">{form.sex === "Female" ? "✔" : ""}</div>
		<div class="overlay civil-single">{form.civil_status === "Single" ? "✔" : ""}</div>
		<div class="overlay civil-married">{form.civil_status === "Married" ? "✔" : ""}</div>
		<div class="overlay type-new">{form.type_student === "New" ? "✔" : ""}</div>
		<div class="overlay type-continuing">{form.type_student === "Continuing" ? "✔" : ""}</div>
		<div class="overlay type-returning">{form.type_student === "Returning" ? "✔" : ""}</div>
		<div class="overlay last">{form.school_last_attended}</div>
		<div class="overlay school_year_last_attended">{form.school_year_last_attended}</div>
		<div class="overlay receipt-yes">{form.receipt === "Yes" ? "✔" : ""}</div>
		<div class="overlay receipt-no">{form.receipt === "No" ? "✔" : ""}</div>
		<div class="overlay contact_number">{form.contact_number}</div>
		<div class="overlay email">{form.email}</div>
		<div class="overlay scholarship">{form.scholarship}</div>
		<div class="overlay father_name">{form.father_name}</div>
		<div class="overlay father_occupation">{form.father_occupation}</div>
		<div class="overlay father_income">{form.father_income}</div>
		<div class="overlay mother_name">{form.mother_name}</div>
		<div class="overlay mother_occupation">{form.mother_occupation}</div>
		<div class="overlay mother_income">{form.mother_income}</div>
		<div class="overlay total_family_income">{form.total_family_income}</div>
	</div>
{/if}
<div class="form-container">
	<!-- <img src="form.png" alt="FHE Form" class="form-bg" /> -->
	<p>date:</p>
	<input type="date" bind:value={form.date} class="date" />
	<p>name:</p>
	<input bind:value={form.name} class="name" />
	<p>id:</p>
	<input bind:value={form.id} class="id" />
	<p>address:</p>
	<input bind:value={form.address} class="address" />
	<p>sex:</p>
	<label><input type="radio" bind:group={form.sex} value="Male" /> Male</label>
	<label><input type="radio" bind:group={form.sex} value="Female" /> Female</label>
	<p>civil status:</p>
	<label><input type="radio" bind:group={form.civil_status} value="Single" /> Single</label>
	<label><input type="radio" bind:group={form.civil_status} value="Married" /> Married</label>
	<p>contact number:</p>
	<input type="tel" pattern="[0-9]{11}" maxlength="11" bind:value={form.contact_number} class="contact_number" placeholder="e.g. 09123456789" />
	<p>email:</p>
	<input bind:value={form.email} class="email" />
	<p>course:</p>
	<input bind:value={form.course} class="course" />
	<p>year level:</p>
	<input type="number" min="1" max="10" bind:value={form.year_level} class="year" />
	<p>type of student:</p>
	<label><input type="radio" bind:group={form.type_student} value="New" /> New</label>
	<label><input type="radio" bind:group={form.type_student} value="Continuing" /> Continuing</label>
	<label><input type="radio" bind:group={form.type_student} value="Returning" /> Returning Student</label>
	{#if form.type_student === "New"}
		<p>School Last Attended:</p>
		<input bind:value={form.school_last_attended} class="school_last_attended" />
		<p>School Year Last Attended:</p>
		<input bind:value={form.school_year_last_attended} class="school_year_last_attended" />
	{/if}
	<p>receipt:</p>
	<label><input type="radio" bind:group={form.receipt} value="Yes" /> Yes</label>
	<label><input type="radio" bind:group={form.receipt} value="No" /> No</label>
	{#if form.receipt === "Yes"}
		<p>scholarship:</p>
		<input bind:value={form.scholarship} class="scholarship" />
	{/if}
	<p>father's name:</p>
	<input bind:value={form.father_name} class="father_name" />
	<p>father's occupation:</p>
	<input bind:value={form.father_occupation} class="father_occupation" />
	<p>father's income:</p>
	<input bind:value={form.father_income} class="father_income" type="number" min="0" on:input={() => updateTotalFamilyIncome()} />
	<p>mother's name:</p>
	<input bind:value={form.mother_name} class="mother_name" />
	<p>mother's occupation:</p>
	<input bind:value={form.mother_occupation} class="mother_occupation" />
	<p>mother's income:</p>
	<input bind:value={form.mother_income} class="mother_income" type="number" min="0" on:input={() => updateTotalFamilyIncome()} />
	<p>total family income:</p>
	<input bind:value={form.total_family_income} class="total_family_income" type="number" min="0" readonly />

	<div class="save-indicator">
		{#if saveStatus === "success"}
			<span class="success-msg">✔ All data saved to database!</span>
		{:else if saveStatus === "error"}
			<span class="error-msg">✖ Error saving: {saveError}</span>
		{/if}
	</div>

	<button on:click={printOfficialForm} class="bg-blue-500 block p-10 m-10">Print Official Form</button>
	<SaveButton onClick={saveToDatabase} />
	<button on:click={() => (showOverlay = !showOverlay)} class="bg-green-500 block p-10 m-10 overlay-toggle-btn">{showOverlay ? "Hide Overlay Preview" : "Show Overlay Preview"}</button>
</div>

<style>
	div > div {
		/* background-color: brown; */
	}
	.overlay-toggle-btn {
		position: absolute;
		top: 20px;
		right: 20px;
		z-index: 10000;
	}
	.form-container {
		position: relative;
		width: 100%;
		height: 100%;
		padding: 20px;
		box-sizing: border-box;
		display: block;
	}
	input {
		width: 90%;
		padding: 5px;
		margin-left: 20px;
		margin-bottom: 20px;
		border: 1px solid #ccc;
		border-radius: 4px;
	}
	.print-page {
		position: relative;
		display: block;
		width: 100%;
		max-width: 1000px;
		margin: auto;
		/* padding-top: 1%; */
	}
	.form-bg {
		display: block;
		width: 100%;
		height: auto;
	}
	.overlay {
		position: absolute;
		font-size: 1em;
		font-family: Arial, sans-serif;
	}
	.date {
		top: 23.5%;
		left: 28.4%;
	}
	.name {
		top: 32.7%;
		left: 19%;
	}
	.id {
		top: 32.7%;
		left: 73%;
	}
	.course {
		top: 37.7%;
		left: 20%;
	}
	.year {
		top: 37.7%;
		left: 74%;
	}
	.address {
		top: 34%;
		left: 33%;
	}
	.sex {
		top: 35.5%;
		left: 24%;
	}
	.civil_status {
		top: 35.5%;
		left: 65%;
	}
	.contact_number {
		top: 36.4%;
		left: 26.7%;
	}
	.email {
		top: 36.4%;
		left: 63.4%;
	}
	.type_student {
		top: 40.5%;
		left: 28%;
	}
	.scholarship_grantee {
		top: 45.5%;
		left: 71%;
	}
	.scholarship {
		top: 47.7%;
		left: 14%;
	}
	.father_name {
		top: 53.7%;
		left: 20%;
	}
	.father_occupation {
		top: 53.7%;
		left: 56%;
	}
	.father_income {
		top: 53.7%;
		left: 73%;
	}
	.mother_name {
		top: 55.1%;
		left: 20%;
	}
	.mother_occupation {
		top: 55.1%;
		left: 56%;
	}
	.mother_income {
		top: 55.1%;
		left: 73%;
	}
	.total_family_income {
		top: 56.5%;
		left: 73%;
	}
	.sex-male {
		top: 35.2%;
		left: 22.5%;
	}
	.sex-female {
		top: 35.2%;
		left: 34.4%;
	}
	.civil-single {
		top: 35.2%;
		left: 63.8%;
	}
	.civil-married {
		top: 35.2%;
		left: 75%;
	}
	.type-new {
		top: 40.3%;
		left: 28.4%;
	}
	.type-continuing {
		top: 40.3%;
		left: 37%;
	}
	.type-returning {
		top: 40.3%;
		left: 46.2%;
	}
	.receipt-yes {
		top: 60%;
		left: 20%;
	}
	.receipt-no {
		top: 60%;
		left: 26%;
	}
	@media print {
		body,
		html {
			background: white !important;
			color: black !important;
		}
		.print-btn {
			display: none;
		}
		.form-container {
			display: none !important;
		}
		input {
			border: none;
			background: transparent;
		}
		.print-page {
			display: block !important;
			position: relative;
			width: 100%;
			max-width: 1000px;
			margin: auto;
			background: white;
			z-index: 9999;
		}
	}
	input[type="radio"] {
		width: 16px;
		height: 16px;
		margin-right: 6px;
		vertical-align: middle;
	}
	label {
		font-size: 1em;
		margin-right: 16px;
	}
	.save-indicator {
		margin-bottom: 10px;
		min-height: 24px;
	}
	.success-msg {
		color: green;
		font-weight: bold;
	}
	.error-msg {
		color: red;
		font-weight: bold;
	}
</style>