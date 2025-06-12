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

  function clearSignature() {
    studentsignaturePad.clear();
    studentsignatureData = "";
  }

  function clearGuardianSignature() {
    guardianSignaturePad.clear();
    guardianSignatureData = "";
  }

  async function submitForm(event) {
    event.preventDefault();

    studentsignatureData = !studentsignaturePad.isEmpty() ? studentsignaturePad.toDataURL() : "";
    guardianSignatureData = !guardianSignaturePad.isEmpty() ? guardianSignaturePad.toDataURL() : "";

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