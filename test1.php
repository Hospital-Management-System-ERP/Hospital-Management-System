<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modern Input Field</title>

<style>
body{
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f4f6f9;
    font-family:'Segoe UI', sans-serif;
}

.form{
    display:flex;
    flex-direction:column;
    gap:20px;
    width:300px;
}

.input-group{
    position:relative;
}

.input-group input{
    width:100%;
    padding:14px 15px;
    border:2px solid #ddd;
    border-radius:8px;
    font-size:16px;
    outline:none;
    background:transparent;
    transition:0.3s ease;
}

.input-group label{
    position:absolute;
    top:50%;
    left:15px;
    transform:translateY(-50%);
    color:#777;
    font-size:16px;
    pointer-events:none;
    transition:0.3s ease;
    background:#f4f6f9;
    padding:0 5px;
}

/* Focus Effect */
.input-group input:focus{
    border-color:#4f46e5;
    box-shadow:0 0 8px rgba(79,70,229,0.2);
}

.input-group input:focus + label,
.input-group input:valid + label{
    top:0;
    font-size:13px;
    color:#4f46e5;
}
</style>

</head>
<body>

<form class="form">
    <div class="input-group">
        <input type="text" required>
        <label>Full Name</label>
    </div>

    <div class="input-group">
        <input type="email" required>
        <label>Email Address</label>
    </div>

    <div class="input-group">
        <input type="password" required>
        <label>Password</label>
    </div>
</form>

</body>
</html>