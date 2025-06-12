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

<div class="flex items-center justify-center min-h-screen"
     style="background-image: url('/background.png'); background-size: cover; background-position: center;">
  <form
    class="backdrop-blur-md bg-white/60 p-8 rounded-2xl shadow-2xl w-full max-w-sm border border-white/30"
    on:submit={handleLogin}
  >
    <!-- Logo Image -->
    <div class="flex justify-center mb-4">
      <img src="/dmmmsu_logo.png" alt="DMMMSU Logo" class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white/80" />
    </div>
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800 drop-shadow">Log In</h1>
    {#if error}
      <div class="mb-2 text-red-600 text-sm text-center">{error}</div>
    {/if}
    <div class="mb-4">
      <label class="block text-gray-700 mb-1 font-medium">Username</label>
      <input
        type="text"
        bind:value={username}
        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/80"
        required
        autocomplete="username"
      />
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 mb-1 font-medium">Password</label>
      <input
        type="password"
        bind:value={password}
        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/80"
        required
        autocomplete="current-password"
      />
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 mb-1 font-medium">Role</label>
      <select
        bind:value={role}
        class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/80"
      >
        <option value="admin">Admin</option>
        <option value="staff">Staff</option>
      </select>
    </div>
    <button
      type="submit"
      class="w-full bg-blue-700/90 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition shadow"
    >
      Log In
    </button>
  </form>
</div>