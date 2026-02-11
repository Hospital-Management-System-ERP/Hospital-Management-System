<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Doctor Daily Schedule</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    padding: 20px;
  }

  .doctor-card {
    display: flex;
    flex-wrap: wrap;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
  }

  .doctor-info {
    flex: 1 1 200px;
    background: #2a9df4;
    color: #fff;
    padding: 20px;
    text-align: center;
  }

  .doctor-info img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 10px;
    border: 3px solid #fff;
  }

  .doctor-info h3 {
    margin: 5px 0;
  }

  .doctor-info p {
    margin: 0;
    font-size: 14px;
  }

  .schedule-table {
    flex: 3 1 500px;
    padding: 20px;
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background: #f0f0f0;
  }

  td button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    background: #2a9df4;
    color: #fff;
    cursor: pointer;
  }

  td button:hover {
    background: #1e7acb;
  }

  @media (max-width: 768px) {
    .doctor-card {
      flex-direction: column;
    }

    .doctor-info, .schedule-table {
      flex: 1 1 100%;
    }
  }
</style>
</head>
<body>

<div class="doctor-card">
  <div class="doctor-info">
    <img src="https://via.placeholder.com/100" alt="Doctor Photo">
    <h3>Dr. Ashraf Ali</h3>
    <p>Cardiologist</p>
  </div>
  <div class="schedule-table">
    <table>
      <thead>
        <tr>
          <th>Time</th>
          <th>Patient Name</th>
          <th>Disease</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>10:00 - 10:30</td>
          <td>John Doe</td>
          <td>Fever</td>
          <td><button>View</button></td>
        </tr>
        <tr>
          <td>10:30 - 11:00</td>
          <td>Jane Smith</td>
          <td>Cold</td>
          <td><button>View</button></td>
        </tr>
        <tr>
          <td>11:00 - 11:30</td>
          <td>Michael Ray</td>
          <td>Diabetes</td>
          <td><button>View</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- You can copy the above card and change doctor/patient data for multiple doctors -->

</body>
</html>
