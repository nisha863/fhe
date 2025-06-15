<script>
  import { onMount } from 'svelte';
  import SignaturePad from "signature_pad";

  let studentcanvas;
  let studentsignaturePad;
  let studentsignatureData = "";

  let guardianCanvas;
  let guardianSignaturePad;
  let guardianSignatureData = "";

  let fullname = "";
  let email = "";
  let phone = "";
  let course = "";
  let id = "";
  let address = "";
  let sex = "";
  let civil_status = "";
  let year_level = "";
  let type_student = [];
  let school_name_last_attended = "";
  let year_last_attended = "";
  let scholarship = "";
  let scholarship_name = "";
  let mother_name = "";
  let father_name = "";
  let mother_occupation = "";
  let father_occupation = "";
  let mother_income = "";
  let father_income = "";
  let date_of_application = "";

  // Picture upload
  let student_picture = null;
  let student_picture_preview = "";

  // Guardian/Parent info
  let guardian_name = "";
  let guardian_relationship = "";

  // Server message
  let serverMessage = "";
  let serverMessageType = ""; // "success" or "error"

  function handlePictureChange(event) {
    const file = event.target.files[0];
    student_picture = file;
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        student_picture_preview = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      student_picture_preview = "";
    }
  }

  onMount(() => {
    studentsignaturePad = new SignaturePad(studentcanvas);
    guardianSignaturePad = new SignaturePad(guardianCanvas);
  });
		const formData = new FormData();
		formData.append("student_picture", student_picture);
		formData.append("student_signature", studentsignatureData);
		formData.append("guardian_signature", guardianSignatureData);
		formData.append("guardian_name", guardian_name);
		formData.append("guardian_relationship", guardian_relationship);
		formData.append("fullname", fullname);
		formData.append("id", id);
		formData.append("address", address);
		formData.append("sex", sex);
		formData.append("civil_status", civil_status);
		formData.append("phone", phone);
		formData.append("email", email);
		formData.append("course", course);
		formData.append("year_level", year_level);
		formData.append("type_student", type_student);
		formData.append("school_name_last_attended", school_name_last_attended);
		formData.append("year_last_attended", year_last_attended);
		formData.append("scholarship", scholarship);
		formData.append("scholarship_name", scholarship_name);
		formData.append("mother_name", mother_name);
		formData.append("father_name", father_name);
		formData.append("mother_occupation", mother_occupation);
		formData.append("father_occupation", father_occupation);
		formData.append("mother_income", mother_income);
		formData.append("father_income", father_income);
		formData.append("date_of_application", date_of_application);

		try {
			const response = await fetch("/api", {
				method: "POST",
				body: formData,
			});

			if (!response.ok) {
				serverMessage = "Submission failed. Please try again.";
				serverMessageType = "error";
				// return ;
			}
  function clearSignature() {
    studentsignaturePad.clear();
    studentsignatureData = "";
  }

    // Use FormData to send the image and other fields
    const formData = new FormData();
    formData.append("student_picture", student_picture);
    formData.append("student_signature", studentsignatureData);
    formData.append("guardian_signature", guardianSignatureData);
    formData.append("guardian_name", guardian_name);
    formData.append("guardian_relationship", guardian_relationship);
    formData.append("fullname", fullname);
    formData.append("id", id);
    formData.append("address", address);
    formData.append("sex", sex);
    formData.append("civil_status", civil_status);
    formData.append("phone", phone);
    formData.append("email", email);
    formData.append("course", course);
    formData.append("year_level", year_level);
    formData.append("type_student", JSON.stringify(type_student));
    formData.append("school_name_last_attended", school_name_last_attended);
    formData.append("year_last_attended", year_last_attended);
    formData.append("scholarship", scholarship);
    formData.append("scholarship_name", scholarship_name);
    formData.append("mother_name", mother_name);
    formData.append("father_name", father_name);
    formData.append("mother_occupation", mother_occupation);
    formData.append("father_occupation", father_occupation);
    formData.append("mother_income", mother_income);
    formData.append("father_income", father_income);
    formData.append("date_of_application", date_of_application);

    studentsignatureData = !studentsignaturePad.isEmpty() ? studentsignaturePad.toDataURL() : "";
    guardianSignatureData = !guardianSignaturePad.isEmpty() ? guardianSignaturePad.toDataURL() : "";


    try {
      const response = await fetch('http://localhost/back-folder/student.php', {
        method: 'POST',
        body: formData
      });

      if (!response.ok) {
        serverMessage = "Submission failed. Please try again.";
        serverMessageType = "error";
        return;
      }

      let result;
      try {
        result = await response.json();
      } catch {
        result = { message: await response.text(), success: false };
      }

      serverMessage = result.message || "Thanks for submitting!";
      serverMessageType = result.success ? "success" : "error";
    } catch (error) {
      serverMessage = "An error occurred. Please try again.";
      serverMessageType = "error";
    }
  }
</script>

<h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Free Higher Education Application Form</h1>

<div class="sm:p-4 bg-gray-100 shadow-md rounded-lg m-[10%]">
	<form on:submit={submitForm}>
		<fieldset class="border border-gray-600 p-2 sm:p-16 rounded-md">
			<legend class="text-lg font-semibold text-gray-700 mb-4">Student Information</legend>
			<!-- basic infos -->

			<!-- date -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
				<div class="flex-1 min-w-0">
					<label for="date_of_application" class="block text-sm font-medium text-gray-700">Date of Application</label>
					<input
						id="date_of_application"
						type="date"
						bind:value={date_of_application}
						class="block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- full name -->
				<div class="flex-1 min-w-0">
					<label for="fullname" class="block text-sm font-medium text-gray-700">Full Name</label>
					<input
						id="fullname"
						type="text"
						bind:value={fullname}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- ID Number -->
				<div class="flex-1 min-w-0">
					<label for="id" class="block text-sm font-medium text-gray-700">ID Number</label>
					<input
						id="id"
						type="number"
						bind:value={id}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- Complete Address -->
				<div class="flex-1 min-w-0">
					<label for="address" class="block text-sm font-medium text-gray-700">Complete Address</label>
					<input
						id="address"
						type="text"
						bind:value={address}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- phone number -->
				<div class="flex-1 min-w-0">
					<label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
					<input
						id="phone"
						type="number"
						bind:value={phone}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- email address -->
				<div class="flex-1 min-w-0">
					<label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
					<input
						id="email"
						type="email"
						bind:value={email}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- Course -->
				<div class="flex-1 min-w-0">
					<label for="course" class="block text-sm font-medium text-gray-700">Course</label>
					<input
						id="course"
						type="text"
						bind:value={course}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<!-- Year Level -->
				<div class="flex-1 min-w-0">
					<label for="year_level" class="block text-sm font-medium text-gray-700">Year Level</label>
					<select
						id="year_level"
						bind:value={year_level}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					>
						<option value="" disabled selected>Select your year</option>
						<option value="1st Year">1st Year</option>
						<option value="2nd Year">2nd Year</option>
						<option value="3rd Year">3rd Year</option>
						<option value="4th Year">4th Year</option>
						<option value="Irregular">Others.</option>
					</select>
				</div>
				<!-- sex: yes syempre -->
				<div class="flex-1 min-w-0">
					<label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
					<div class="flex space-x-4 mt-1">
						<label for="male" class="inline-flex items-center">
							<input id="male" type="radio" bind:group={sex} value="Male" class="form-radio text-blue-600" required />
							<span class="ml-2">Male</span>
						</label>
						<label for="female" class="inline-flex items-center">
							<input id="female" type="radio" bind:group={sex} value="Female" class="form-radio text-blue-600" required />
							<span class="ml-2">Female</span>
						</label>
					</div>
				</div>
				<!-- Civil Status -->
				<div class="flex-1 min-w-0">
					<label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
					<div class="flex space-x-4 mt-1">
						<label for="single" class="inline-flex items-center">
							<input id="single" type="radio" bind:group={civil_status} value="Single" class="form-radio text-blue-600" required />
							<span class="ml-2">Single</span>
						</label>
						<label for="married" class="inline-flex items-center">
							<input id="married" type="radio" bind:group={civil_status} value="Married" class="form-radio text-blue-600" required />
							<span class="ml-2">Married</span>
						</label>
					</div>
				</div>
			</div>
			<!-- Type of Student -->
			<div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
				<div class="flex-1 min-w-0">
					<label for="type_student" class="block text-sm font-medium text-gray-700 mb-1" id="type_student_label">Type of Student</label>
					<div class="flex items-center gap-2" role="radiogroup" aria-labelledby="type_student_label">
						<input
							id="type_student_new"
							type="radio"
							bind:group={type_student}
							value="New"
							class="form-radio h-5 w-5 text-blue-600"
							required
						/>
						<label for="type_student_new" class="ml-2 text-gray-700">New</label>
						<input
							id="type_student_continuing"
							type="radio"
							bind:group={type_student}
							value="Continuing"
							class="form-radio h-5 w-5 text-blue-600"
							required
						/>
						<label for="type_student_continuing" class="ml-2 text-gray-700">Continuing</label>
						<input
							id="type_student_returning"
							type="radio"
							bind:group={type_student}
							value="Returning"
							class="form-radio h-5 w-5 text-blue-600"
							required
						/>
						<label for="type_student_returning" class="ml-2 text-gray-700">Returning</label>
					</div>

					<!-- If New Student -->
					{#if type_student === "New"}
						<label for="school_name_last_attended" class="block text-sm font-medium text-gray-700 mb-1 mt-2">
							If <span class="font-semibold">NEW</span>, indicate name of school last attended
						</label>
						<input
							id="school_name_last_attended"
							type="text"
							bind:value={school_name_last_attended}
							class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
							required
						/>
						<div class="flex-1 min-w-0">
							<label for="school_year_last_attended" class="block text-sm font-medium text-gray-700 mb-1">
								School Year Last Attended
							</label>
							<input
								id="school_year_last_attended"
								type="text"
								bind:value={year_last_attended}
								class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
								required
							/>
						</div>
					{/if}
				</div>
				<!-- Scholarship Section -->
				<div class="flex-1 min-w-0">
					<label for="scholarship" class="block text-sm font-medium text-gray-700 mb-1">Are you a recipient of any scholarship/grant?</label
					>
					<div class="flex flex-row gap-2 md:gap-8">
						<label class="inline-flex items-center">
							<input
								id="scholarship_yes"
								type="radio"
								bind:group={scholarship}
								value="Yes"
								class="form-radio h-5 w-5 text-blue-600"
								required
							/>
							<span class="ml-2 text-gray-700">Yes</span>
						</label>
						<label class="inline-flex items-center">
							<input
								id="scholarship_no"
								type="radio"
								bind:group={scholarship}
								value="No"
								class="form-radio h-5 w-5 text-blue-600"
								required
							/>
							<span class="ml-2 text-gray-700">No</span>
						</label>
					</div>
					{#if scholarship === "Yes"}
						<div class="mt-2">
							<label for="scholarship_name" class="block text-sm font-medium text-gray-700">Name of Scholarship</label>
							<input
								id="scholarship_name"
								type="text"
								bind:value={scholarship_name}
								class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
								required
							/>
						</div>
					{/if}
				</div>
			</div>

			<!-- Parent Info Row -->
			<div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
				<div class="flex-1 min-w-0">
					<label for="father_name" class="block text-sm font-medium text-gray-700 mb-1">Father Name</label>
					<input
						id="father_name"
						type="text"
						bind:value={father_name}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<div class="flex-1 min-w-0">
					<label for="mother_name" class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
					<input
						id="mother_name"
						type="text"
						bind:value={mother_name}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
			</div>
			<div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
				<div class="flex-1 min-w-0">
					<label for="father_occupation" class="block text-sm font-medium text-gray-700 mb-1">Father Occupation</label>
					<input
						id="father_occupation"
						type="text"
						bind:value={father_occupation}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<div class="flex-1 min-w-0">
					<label for="mother_occupation" class="block text-sm font-medium text-gray-700 mb-1">Mother Occupation</label>
					<input
						id="mother_occupation"
						type="text"
						bind:value={mother_occupation}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
			</div>
			<div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
				<div class="flex-1 min-w-0">
					<label for="father_income" class="block text-sm font-medium text-gray-700 mb-1">Father Estimated Income</label>
					<input
						id="father_income"
						type="text"
						bind:value={father_income}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<div class="flex-1 min-w-0">
					<label for="mother_income" class="block text-sm font-medium text-gray-700 mb-1">Mother Estimated Income</label>
					<input
						id="mother_income"
						type="number"
						bind:value={mother_income}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
			</div>

			<!-- Student Signature Section -->
			<div class="mb-4">
				<label class="block text-sm font-medium text-gray-700 mb-1">Student Signature</label>
				{#if studentsignatureData}
					<img src={studentsignatureData} alt="Student Signature Preview" style="max-width:10rem;display:block;margin-bottom:8px;" />
					<button
						type="button"
						on:click={openStudentSignatureModal}
						class="signature-btn bg-green-600 text-white rounded hover:bg-green-700 transition">Edit Signature</button
					>
				{:else}
					<button
						type="button"
						on:click={openStudentSignatureModal}
						class="signature-btn bg-blue-600 text-white rounded hover:bg-blue-700 transition"
					>
						Add Signature
					</button>
				{/if}
			</div>
			<SignatureModal
				show={showStudentSignatureModal}
				value={studentsignatureData}
				label="Student Signature"
				on:close={closeStudentSignatureModal}
				on:save={handleStudentSignatureSave}
			/>

			<!-- Guardian/Parent Info Section -->
			<div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
				<div class="flex-1 min-w-0">
					<label for="guardian_name" class="block text-sm font-medium text-gray-700 mb-1">Guardian/Parent Name</label>
					<input
						id="guardian_name"
						type="text"
						bind:value={guardian_name}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					/>
				</div>
				<div class="flex-1 min-w-0">
					<label for="guardian_relationship" class="block text-sm font-medium text-gray-700 mb-1">Relationship to Student</label>
					<select
						id="guardian_relationship"
						bind:value={guardian_relationship}
						class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
						required
					>
						<option value="" disabled selected>Select relationship</option>
						<option value="Father">Father</option>
						<option value="Mother">Mother</option>
						<option value="Guardian">Guardian</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div>

			<!-- Guardian/Parent Signature Section -->
			<div class="mb-4" >
				<label class="block text-sm font-medium text-gray-700 mb-1">Guardian/Parent Signature</label>
				{#if guardianSignatureData}
					<img src={guardianSignatureData} alt="Guardian Signature Preview" style="max-width:10rem;display:block;margin-bottom:8px;" />
					<button
						type="button"
						on:click={openGuardianSignatureModal}
						class="signature-btn bg-green-600 text-white rounded hover:bg-green-700 transition">Edit Signature</button
					>
				{:else}
					<button
						type="button"
						on:click={openGuardianSignatureModal}
						class="signature-btn bg-blue-600 text-white rounded hover:bg-blue-700 transition"
					>
						Add Signature
					</button>
				{/if}
			</div>
			<SignatureModal
				show={showGuardianSignatureModal}
				value={guardianSignatureData}
				label="Guardian/Parent Signature"
				on:close={closeGuardianSignatureModal}
				on:save={handleGuardianSignatureSave}
			/>

			<!-- 2x2 Picture Upload as a Button -->
			<div class="mb-4" style="max-width: 10rem;">
				<label for="student_picture" class="block text-sm font-medium text-gray-700 mb-1">Upload 2x2 Picture</label>
				<label class="picture-btn inline-block cursor-pointer bg-blue-600 text-white rounded hover:bg-blue-700 transition">
					Choose Picture
					<input
						id="student_picture"
						type="file"
						accept="image/*"
						on:change={handlePictureChange}
						class="hidden"
						required
						tabindex="-1"
						style="display:none"
					/>
				</label>
				{#if student_picture_preview}
					<img src={student_picture_preview} alt="2x2 Preview" class="mt-2 w-20 h-20 sm:w-24 sm:h-24 object-cover border rounded" />
				{/if}
			</div>

			<!-- Button Section: Stack on mobile, row on desktop -->
			<div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-10">
				<button
					type="submit"
					class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
					style="min-width: 140px;">Submit</button
				>
				<!-- <button type="button" on:click={openPrintModal} class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition" style="min-width: 140px;">Print Form</button> -->
				<button
					type="button"
					on:click={openPreviewModal}
					class="inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition"
					style="min-width: 140px;">Preview Form</button
				>
				<button
					type="button"
					on:click={() => window.location.href = "/viewlist_students"}
					class="inline-block bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition"
					style="min-width: 140px;">
					View List of Students
				</button>
			</div>
		</fieldset>
	</form>
	{#if serverMessage}
		<div class="mb-4 p-3 rounded border text-center"
			class:bg-green-100={serverMessageType === 'success'}
			class:text-green-800={serverMessageType === 'success'}
			class:border-green-300={serverMessageType === 'success'}
			class:bg-red-100={serverMessageType === 'error'}
			class:text-red-800={serverMessageType === 'error'}
			class:border-red-300={serverMessageType === 'error'}>
			{serverMessage}
		</div>
	{/if}
</div>

<FHEPrintModal
	show={showPrintModal}
	on:close={closePrintModal}
	formData={{
		fullname,
		email,
		phone,
		course,
		id,
		address,
		sex,
		civil_status,
		year_level,
		type_student,
		school_name_last_attended,
		year_last_attended,
		scholarship,
		scholarship_name,
		mother_name,
		father_name,
		mother_occupation,
		father_occupation,
		mother_income,
		father_income,
		date_of_application,
		guardian_name,
		guardian_relationship,
		student_picture: student_picture_preview,
	}}
	pdfUrl={"/form.pdf"}
/>
<FHEPreviewModal
	show={showPreviewModal}
	on:close={closePreviewModal}
	formData={{
		studentsignatureData,
		guardianSignatureData,
		student_picture: student_picture_preview,
		fullname,
		email,
		phone,
		course,
		id,
		address,
		sex,
		civil_status,
		year_level,
		type_student,
		school_name_last_attended,
		year_last_attended,
		scholarship,
		scholarship_name,
		mother_name,
		father_name,
		mother_occupation,
		father_occupation,
		mother_income,
		father_income,
		date_of_application,
		guardian_name,
		guardian_relationship,
		total_income,
	}}
	pdfUrl={"/form.pdf"}
/>

<style>
	label {
		display: block;
		/* margin-bottom: 0.5rem; */
	}
	input{
		/* padding: 0.5rem; */
		border-radius: 0.3rem;
		box-shadow: 0.1rem 0.2rem 0.5rem rgba(0, 0, 0, 0.1);
	}
	input[type="radio"],
	input[type="checkbox"] {
		border-radius: 1rem;
		padding: 0.5rem;
	}
	.signature-btn,
	.picture-btn {
		display: inline-block;
		width: 10rem;
		min-width: 10rem;
		max-width: 100%;
		padding: 0.5rem 0;
		font-size: 1rem;
		text-align: center;
	}

	input:not([type="radio"]):not([type="checkbox"]),
	select,
	textarea {
  display: block;
  margin-left: 0.4rem;
  margin-right: auto;
  width: 90%;
  /* text-align: center; */
}

input[type="radio"],
input[type="checkbox"] {
  margin: 0 0.25rem 0 0;
  width: auto;
  display: inline-block;
  vertical-align: middle;
}

	@media (min-width: 1024px) {
		form, form * {
			transform: scale(1.02);
			transform-origin: top left;
		}
	}
</style>
<div class="mx-auto p-2 sm:p-4 bg-gray-100 shadow-md rounded-lg" style="max-width:900px;">
  {#if serverMessage}
    <div class="mb-4 p-3 rounded border text-center"
      class:bg-green-100={serverMessageType === 'success'}
      class:text-green-800={serverMessageType === 'success'}
      class:border-green-300={serverMessageType === 'success'}
      class:bg-red-100={serverMessageType === 'error'}
      class:text-red-800={serverMessageType === 'error'}
      class:border-red-300={serverMessageType === 'error'}>
      {serverMessage}
    </div>
  {/if}
  <form on:submit={submitForm}>
    <fieldset class="border border-gray-600 p-2 sm:p-16 rounded-md">
      <legend class="text-lg font-semibold text-gray-700 px-2 mb-4">Student Information</legend>

      <!-- Row: Date, Full Name, ID -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Date of Application</label>
          <input type="text" bind:value={date_of_application} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Full Name</label>
          <input type="text" bind:value={fullname} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">ID Number</label>
          <input type="text" bind:value={id} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
      </div>

      <!-- Row: Address, Phone, Email -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Complete Address</label>
          <input type="text" bind:value={address} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Phone Number</label>
          <input type="text" bind:value={phone} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Email address</label>
          <input type="email" bind:value={email} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
      </div>

      <!-- Row: Course, Year Level, Type of Student -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Course</label>
          <input type="text" bind:value={course} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Year Level</label>
          <select bind:value={year_level} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required>
            <option value="" disabled selected>Select your year</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
          </select>
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Type of Student</label>
          <div class="flex flex-row gap-2 md:gap-4">
            <label class="inline-flex items-center">
              <input type="checkbox" bind:group={type_student} value="New" class="form-checkbox h-5 w-5 text-blue-600">
              <span class="ml-2 text-gray-700">New</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" bind:group={type_student} value="Continuing" class="form-checkbox h-5 w-5 text-blue-600">
              <span class="ml-2 text-gray-700">Continuing</span>
            </label>
            <label class="inline-flex items-center">
              <input type="checkbox" bind:group={type_student} value="Returning" class="form-checkbox h-5 w-5 text-blue-600">
              <span class="ml-2 text-gray-700">Returning</span>
            </label>
          </div>
        </div>
      </div>

      <!-- Sex & Civil Status Row -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Sex</label>
          <div class="flex space-x-4 mt-1">
            <label class="inline-flex items-center">
              <input type="radio" bind:group={sex} value="Male" class="form-radio text-blue-600" required />
              <span class="ml-2">Male</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" bind:group={sex} value="Female" class="form-radio text-blue-600" required />
              <span class="ml-2">Female</span>
            </label>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700">Civil Status</label>
          <div class="flex space-x-4 mt-1">
            <label class="inline-flex items-center">
              <input type="radio" bind:group={civil_status} value="Single" class="form-radio text-blue-600" required />
              <span class="ml-2">Single</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" bind:group={civil_status} value="Married" class="form-radio text-blue-600" required />
              <span class="ml-2">Married</span>
            </label>
          </div>
        </div>
      </div>

      <!-- If New Student -->
      {#if type_student.includes("New")}
        <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
          <div class="flex-1 min-w-0">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              If <span class="font-semibold">NEW</span>, indicate name of school last attended
            </label>
            <input type="text" bind:value={school_name_last_attended} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
          </div>
          <div class="flex-1 min-w-0">
            <label class="block text-sm font-medium text-gray-700 mb-1">
              School Year Last Attended
            </label>
            <input
              type="text"
              bind:value={year_last_attended}
              class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
              required
            />
          </div>
        </div>
      {/if}

      <!-- Scholarship Section -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Are you a recipient of any scholarship/grant?</label>
          <div class="flex flex-row gap-2 md:gap-6">
            <label class="inline-flex items-center">
              <input type="radio" bind:group={scholarship} value="Yes" class="form-radio h-5 w-5 text-blue-600" required>
              <span class="ml-2 text-gray-700">Yes</span>
            </label>
            <label class="inline-flex items-center">
              <input type="radio" bind:group={scholarship} value="No" class="form-radio h-5 w-5 text-blue-600" required>
              <span class="ml-2 text-gray-700">No</span>
            </label>
          </div>
          {#if scholarship === "Yes"}
            <div class="mt-2">
              <label class="block text-sm font-medium text-gray-700">Name of Scholarship</label>
              <input type="text" bind:value={scholarship_name} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
            </div>
          {/if}
        </div>
      </div>

      <!-- Parent Info Row -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Father Name</label>
          <input type="text" bind:value={father_name} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Mother Name</label>
          <input type="text" bind:value={mother_name} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
      </div>
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Father Occupation</label>
          <input type="text" bind:value={father_occupation} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Mother Occupation</label>
          <input type="text" bind:value={mother_occupation} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
      </div>
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Father Estimated Income</label>
          <input type="text" bind:value={father_income} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Mother Estimated Income</label>
          <input type="text" bind:value={mother_income} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
      </div>

      <!-- Student Signature Section -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Student Signature</label>
        <div class="border border-gray-700 rounded bg-white">
          <canvas bind:this={studentcanvas} width="300" height="100" class="block mx-auto bg-white"></canvas>
        </div>
        <button type="button" on:click={clearSignature} class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Clear Signature</button>
      </div>

      <!-- Guardian/Parent Info Section -->
      <div class="mb-4 flex flex-col md:flex-row gap-2 md:gap-4 flex-wrap">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Guardian/Parent Name</label>
          <input type="text" bind:value={guardian_name} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required />
        </div>
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Relationship to Student</label>
          <select bind:value={guardian_relationship} class="mt-1 block w-full max-w-xs border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm" required>
            <option value="" disabled selected>Select relationship</option>
            <option value="Father">Father</option>
            <option value="Mother">Mother</option>
            <option value="Guardian">Guardian</option>
            <option value="Other">Other</option>
          </select>
        </div>
      </div>

      <!-- Guardian/Parent Signature Section -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Guardian/Parent Signature</label>
        <div class="border border-gray-700 rounded bg-white">
          <canvas bind:this={guardianCanvas} width="300" height="100" class="block mx-auto bg-white"></canvas>
        </div>
        <button type="button" on:click={clearGuardianSignature} class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Clear Signature</button>
      </div>

      <!-- 2x2 Picture Upload as a Button -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Upload 2x2 Picture</label>
        <label class="inline-block cursor-pointer bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
          Choose Picture
          <input type="file" accept="image/*" on:change={handlePictureChange} class="hidden" required/>
        </label>
        {#if student_picture_preview}
          <img src={student_picture_preview} alt="2x2 Preview" class="mt-2 w-20 h-20 sm:w-24 sm:h-24 object-cover border rounded" />
        {/if}
      </div>

      <!-- Button Section: Stack on mobile, row on desktop -->
      <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 mt-4">
      <a href="/" class="inline-block text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition" style="min-width: 140px;">Next</a>
        <button type="submit"  class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition" style="min-width: 140px;">Submit</button>
      </div>
    </fieldset>
  </form>
</div>
