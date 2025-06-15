<script>
  let lrn = "";
  let student_name = "";
  let address = "";
  let barangay = "";
  let municipality = "";
  let province = "";
  let zip = "";
  let birthdate = "";
  let birthplace = "";
  let age = "";
  let citizenship = "";
  let religion = "";
  let sex = "";
  let civil_status = "";
  let contact = "";
  let guardian = "";
  let relationship = "";
  let occupation = "";
  let income = "";
  let educational_attainment = "";
  let special_group = [];
  let working_student = "";

  async function submitForm(event) {
    event.preventDefault();
    const formData = {
      lrn,
      student_name,
      address,
      barangay,
      municipality,
      province,
      zip,
      birthdate,
      birthplace,
      age,
      citizenship,
      religion,
      sex,
      civil_status,
      contact,
      guardian,
      relationship,
      occupation,
      income,
      educational_attainment,
      special_group,
      working_student
    };
    console.log(formData);
    // Send to backend if needed
  }
</script>

<h1 class="text-xl font-bold text-center mb-6">Student Information Sheet</h1>

<form on:submit={submitForm} class="max-w-2xl mx-auto p-4 bg-white shadow rounded">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
      <label>LRN</label>
      <input type="text" bind:value={lrn} class="input" required />
    </div>
    <div>
      <label>Student Name</label>
      <input type="text" bind:value={student_name} class="input" required />
    </div>
    <div>
      <label>Address</label>
      <input type="text" bind:value={address} class="input" />
    </div>
    <div>
      <label>Barangay</label>
      <input type="text" bind:value={barangay} class="input" />
    </div>
    <div>
      <label>Municipality</label>
      <input type="text" bind:value={municipality} class="input" />
    </div>
    <div>
      <label>Province</label>
      <input type="text" bind:value={province} class="input" />
    </div>
    <div>
      <label>Zip Code</label>
      <input type="text" bind:value={zip} class="input" />
    </div>
    <div>
      <label>Birth Date</label>
      <input type="date" bind:value={birthdate} class="input" />
    </div>
    <div>
      <label>Birth Place</label>
      <input type="text" bind:value={birthplace} class="input" />
    </div>
    <div>
      <label>Age</label>
      <input type="number" bind:value={age} class="input" min="0" />
    </div>
    <div>
      <label>Citizenship</label>
      <input type="text" bind:value={citizenship} class="input" />
    </div>
    <div>
      <label>Religion</label>
      <input type="text" bind:value={religion} class="input" />
    </div>
    <div>
      <label>Sex</label>
      <select bind:value={sex} class="input">
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
    </div>
    <div>
      <label>Civil Status</label>
      <select bind:value={civil_status} class="input">
        <option value="">Select</option>
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Widowed">Widowed</option>
        <option value="Separated">Separated</option>
      </select>
    </div>
    <div>
      <label>Contact No.</label>
      <input type="text" bind:value={contact} class="input" />
    </div>
  </div>

  <h2 class="mt-6 font-semibold">Guardian Information</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
    <div>
      <label>Guardian's Name</label>
      <input type="text" bind:value={guardian} class="input" />
    </div>
    <div>
      <label>Relationship</label>
      <input type="text" bind:value={relationship} class="input" />
    </div>
    <div>
      <label>Occupation</label>
      <input type="text" bind:value={occupation} class="input" />
    </div>
    <div>
      <label>Monthly Income</label>
      <input type="text" bind:value={income} class="input" />
    </div>
    <div>
      <label>Educational Attainment</label>
      <input type="text" bind:value={educational_attainment} class="input" />
    </div>
  </div>

  <h2 class="mt-6 font-semibold">Other Information</h2>
  <div class="mb-4">
    <label class="block">Are you a member of any special group?</label>
    <div class="flex flex-wrap gap-4 mt-2">
      <label><input type="checkbox" bind:group={special_group} value="IP" /> IP</label>
      <label><input type="checkbox" bind:group={special_group} value="PWD" /> PWD</label>
      <label><input type="checkbox" bind:group={special_group} value="4Ps" /> 4Ps</label>
      <label><input type="checkbox" bind:group={special_group} value="OFW" /> OFW Dependent</label>
      <label><input type="checkbox" bind:group={special_group} value="Solo Parent" /> Solo Parent</label>
    </div>
  </div>

  <div class="mb-6">
    <label>Are you a working student?</label>
    <select bind:value={working_student} class="input">
      <option value="">Select</option>
      <option value="Yes">Yes</option>
      <option value="No">No</option>
    </select>
  </div>

  <div class="flex gap-4">
    <a href="/" class="flex-1 text-center bg-gray-200 text-blue-700 py-2 px-4 rounded hover:bg-gray-300 transition">Back</a>
    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Submit</button>
  </div>
</form>

<style>
  .input {
    @apply mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500;
  }
</style>