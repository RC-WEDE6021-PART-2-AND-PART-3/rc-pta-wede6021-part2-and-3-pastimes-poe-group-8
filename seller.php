<!DOCTYPE html>
<html>
<head>
<title>Sell Item</title>

<style>
body {
    font-family: Arial;
    background: #F5F5F0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    background: white;
    padding: 30px;
    width: 300px;
}
input, button {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
}
button {
    background: #E8491E;
    color: white;
    border: none;
}
</style>

</head>

<body>

<div class="card">

    <h2>Upload Item</h2>

    <?php if (!empty($message)) echo "<p style='color:green;'>" . htmlspecialchars($message) . "</p>"; ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="item_name" placeholder="Item Name" required>

        <input type="number" name="price" placeholder="Price" required>

        <input type="file" name="image" required>

        <button type="submit">Upload</button>

    </form>

</div>

</body>
</html>