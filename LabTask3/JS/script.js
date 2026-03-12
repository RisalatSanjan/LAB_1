console.log("connected");

let invalidCount = 0;

function collect_data() {

  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;

  let valid = true;

  if (!email) {
    document.getElementById("emailErr").innerHTML = "Email is required";
    valid = false;
  }
  else if (!email.includes("@")) {
    document.getElementById("emailErr").innerHTML = "Email must contain @";
    valid = false;
  }
  else {
    document.getElementById("emailErr").innerHTML = "";
  }

  if (!password) {
    document.getElementById("passwordErr").innerHTML = "Password is required";
    valid = false;
  }
  else if (password.length < 6) {
    document.getElementById("passwordErr").innerHTML = "Password must be at least 6 characters";
    valid = false;
  }
  else if (!password.includes("#")) {
    document.getElementById("passwordErr").innerHTML = "Password must contain #";
    valid = false;
  }
  else {
    document.getElementById("passwordErr").innerHTML = "";
  }

  if (!valid) {
    invalidCount++;
    document.getElementById("attemptCount").innerHTML =
      "Invalid Attempts: " + invalidCount;
    return false;
  }

  alert("Login successful!");
  return false;
}

function getEmail() {
  const email = document.getElementById("email").value;
  console.log(email);
}

function getPassword() {
  const password = document.getElementById("password").value;
  console.log(password);
}