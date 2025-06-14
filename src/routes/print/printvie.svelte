<script>
    import { onMount } from "svelte";

    let date_of_application = "";
    let fullname = "";
    let id = "";
    let address = "";
    let sex = "";
    let civil_status = "";
    let phone = "";
    let email = "";
    let course = "";
    let year_level = "";
    let type_student = "";
    let school_name_last_attended = "";
    let year_last_attended = "";
    let receipt = "";
    let scholarship = "";
    let scholarship_name = "";
    let father_name = "";
    let father_occupation = "";
    let father_income = "";
    let mother_name = "";
    let mother_occupation = "";
    let mother_income = "";
    let total_family_income = "";

    let showOverlay = false;
    let saveStatus = "";
    let saveError = "";

    function printOfficialForm() {
        showOverlay = true;
        setTimeout(() => window.print(), 100);
        setTimeout(() => (showOverlay = false), 1000);
    }

    onMount(() => {
        if (!date_of_application) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, "0");
            const dd = String(today.getDate()).padStart(2, "0");
            date_of_application = `${yyyy}-${mm}-${dd}`;
        }
        updateTotalFamilyIncome();
    });

    function updateTotalFamilyIncome() {
        const father = parseFloat(father_income) || 0;
        const mother = parseFloat(mother_income) || 0;
        total_family_income = (father + mother).toString();
    }

    async function saveToDatabase() {
        const form = {
            date_of_application,
            fullname,
            id,
            address,
            sex,
            civil_status,
            phone,
            email,
            course,
            year_level,
            type_student,
            school_name_last_attended,
            year_last_attended,
            receipt,
            scholarship,
            scholarship_name,
            father_name,
            father_occupation,
            father_income,
            mother_name,
            mother_occupation,
            mother_income,
            total_family_income
        };
        try {
            const response = await fetch("http://localhost/student.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(form),
            });
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
        <div class="overlay date">{date_of_application}</div>
        <div class="overlay name">{fullname}</div>
        <div class="overlay id">{id}</div>
        <div class="overlay address">{address}</div>
        <div class="overlay course">{course}</div>
        <div class="overlay year">{year_level}</div>
        <div class="overlay sex-male">{sex === "Male" ? "✔" : ""}</div>
        <div class="overlay sex-female">{sex === "Female" ? "✔" : ""}</div>
        <div class="overlay civil-single">{civil_status === "Single" ? "✔" : ""}</div>
        <div class="overlay civil-married">{civil_status === "Married" ? "✔" : ""}</div>
        <div class="overlay type-new">{type_student === "New" ? "✔" : ""}</div>
        <div class="overlay type-continuing">{type_student === "Continuing" ? "✔" : ""}</div>
        <div class="overlay type-returning">{type_student === "Returning" ? "✔" : ""}</div>
        <div class="overlay last">{school_name_last_attended}</div>
        <div class="overlay school_year_last_attended">{year_last_attended}</div>
        <div class="overlay receipt-yes">{receipt === "Yes" ? "✔" : ""}</div>
        <div class="overlay receipt-no">{receipt === "No" ? "✔" : ""}</div>
        <div class="overlay scholarship">{scholarship}</div>
        <div class="overlay scholarship_name">{scholarship_name}</div>
        <div class="overlay father_name">{father_name}</div>
        <div class="overlay father_occupation">{father_occupation}</div>
        <div class="overlay father_income">{father_income}</div>
        <div class="overlay mother_name">{mother_name}</div>
        <div class="overlay mother_occupation">{mother_occupation}</div>
        <div class="overlay mother_income">{mother_income}</div>
        <div class="overlay total_family_income">{total_family_income}</div>
    </div>
{/if}

<div class="form-container">
    <p>Date of Application:</p>
    <input type="date" bind:value={date_of_application} />

    <p>Full Name:</p>
    <input bind:value={fullname} />

    <p>ID Number:</p>
    <input bind:value={id} />

    <p>Address:</p>
    <input bind:value={address} />

    <p>Sex:</p>
    <label><input type="radio" bind:group={sex} value="Male" /> Male</label>
    <label><input type="radio" bind:group={sex} value="Female" /> Female</label>

    <p>Civil Status:</p>
    <label><input type="radio" bind:group={civil_status} value="Single" /> Single</label>
    <label><input type="radio" bind:group={civil_status} value="Married" /> Married</label>

    <p>Phone Number:</p>
    <input type="tel" pattern="[0-9]{11}" maxlength="11" bind:value={phone} placeholder="e.g. 09123456789" />

    <p>Email:</p>
    <input type="email" bind:value={email} />

    <p>Course:</p>
    <input bind:value={course} />

    <p>Year Level:</p>
    <select bind:value={year_level}>
        <option value="" disabled>Select your year</option>
        <option value="1st Year">1st Year</option>
        <option value="2nd Year">2nd Year</option>
        <option value="3rd Year">3rd Year</option>
        <option value="4th Year">4th Year</option>
    </select>

    <p>Type of Student:</p>
    <label><input type="radio" bind:group={type_student} value="New" /> New</label>
    <label><input type="radio" bind:group={type_student} value="Continuing" /> Continuing</label>
    <label><input type="radio" bind:group={type_student} value="Returning" /> Returning Student</label>

    {#if type_student === "New"}
        <p>School Last Attended:</p>
        <input bind:value={school_name_last_attended} />
        <p>School Year Last Attended:</p>
        <input bind:value={year_last_attended} />
    {/if}

    <p>Are you a recipient of any scholarship/grant?</p>
    <label><input type="radio" bind:group={receipt} value="Yes" /> Yes</label>
    <label><input type="radio" bind:group={receipt} value="No" /> No</label>

    {#if receipt === "Yes"}
        <p>Scholarship:</p>
        <input bind:value={scholarship} />
        <p>Name of Scholarship:</p>
        <input bind:value={scholarship_name} />
    {/if}

    <p>Father's Name:</p>
    <input bind:value={father_name} />

    <p>Father's Occupation:</p>
    <input bind:value={father_occupation} />

    <p>Father's Income:</p>
    <input type="number" min="0" bind:value={father_income} on:input={updateTotalFamilyIncome} />

    <p>Mother's Name:</p>
    <input bind:value={mother_name} />

    <p>Mother's Occupation:</p>
    <input bind:value={mother_occupation} />

    <p>Mother's Income:</p>
    <input type="number" min="0" bind:value={mother_income} on:input={updateTotalFamilyIncome} />

    <p>Total Family Income:</p>
    <input type="number" min="0" bind:value={total_family_income} readonly />

    <div class="save-indicator">
        {#if saveStatus === "success"}
            <span class="success-msg">✔ All data saved to database!</span>
        {:else if saveStatus === "error"}
            <span class="error-msg">✖ Error saving: {saveError}</span>
        {/if}
    </div>

    <button type="button" on:click={printOfficialForm} class="bg-blue-500 block p-10 m-10">Print Official Form</button>
    <button type="button" on:click={saveToDatabase} class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save to Database</button>
    <button type="button" on:click={() => (showOverlay = !showOverlay)} class="bg-green-500 block p-10 m-10 overlay-toggle-btn">{showOverlay ? "Hide Overlay Preview" : "Show Overlay Preview"}</button>
</div>

<style>
    .form-container {
        position: relative;
        width: 100%;
        height: 100%;
        padding: 20px;
        box-sizing: border-box;
        display: block;
    }
    input, select {
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
    .overlay-toggle-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10000;
    }
    @media print {
        .form-container { display: none !important; }
        .print-page { display: block !important; }
    }
</style>