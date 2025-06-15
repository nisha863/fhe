<script>
  let username = "";
  let password = "";
  let role = "admin"; // default selection
  let error = "";

  function handleLogin(event) {
    event.preventDefault();
    // Replace this with your actual login logic (API call, etc.)
    if (!username || !password) {
      error = "Please enter both username and password.";
      return;
    }
    // Example: send { username, password, role } to your backend
    // fetch('/api/login', { ... })
    error = "";
    alert(`Logging in as ${role}: ${username}`);
  }
</script>

<div class="flex items-center justify-center min-h-screen bg-gray-100">
  <form class="bg-white p-6 rounded shadow-md w-full max-w-xs" on:submit={handleLogin}>
    <h1 class="text-2xl font-bold mb-4 text-center">Log In</h1>
    {#if error}
      <div class="mb-2 text-red-600 text-sm">{error}</div>
    {/if}
    <div class="mb-4">
      <label class="block text-gray-700 mb-1">Username</label>
      <input type="text" bind:value={username} class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400" required />
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 mb-1">Password</label>
      <input type="password" bind:value={password} class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400" required />
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 mb-1">Role</label>
      <select bind:value={role} class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-400">
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
      </select>
    </div>
    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Log In</button>
  </form>
</div>