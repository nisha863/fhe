<script>
  import { onMount } from 'svelte';

  let students = [];
  let loading = true;
  let error = "";

  onMount(async () => {
    try {
      const res = await fetch('http://localhost/back-folder/get_students.php');
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
    <table class="min-w-full bg-white border border-gray-300 shadow rounded">
      <thead>
        <tr class="bg-blue-600 text-white">
          <th class="py-2 px-4 border">#</th>
          <th class="py-2 px-4 border">Full Name</th>
          <th class="py-2 px-4 border">ID Number</th>
          <th class="py-2 px-4 border">Course</th>
          <th class="py-2 px-4 border">Year Level</th>
          <th class="py-2 px-4 border">Date of Application</th>
        </tr>
      </thead>
      <tbody>
        {#each students as student, i}
          <tr class="hover:bg-gray-100">
            <td class="py-2 px-4 border">{i + 1}</td>
            <td class="py-2 px-4 border">{student.fullname}</td>
            <td class="py-2 px-4 border">{student.id_number}</td>
            <td class="py-2 px-4 border">{student.course}</td>
            <td class="py-2 px-4 border">{student.year_level}</td>
            <td class="py-2 px-4 border">{student.date_of_application}</td>
          </tr>
        {/each}
      </tbody>
    </table>
  </div>
  <div class="flex justify-end mt-6">
    <button on:click={printPage} class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
      Print List
    </button>
  </div>
{/if}