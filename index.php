<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Remote Work Survey</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <style>
    .question-box {
      background: #f8f9fa;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .radio-option {
      padding: 8px 10px;
      border-radius: 4px;
      margin-bottom: 8px;
    }

    .radio-option:hover {
      background-color: #e9ecef;
    }
  </style>
</head>

<body class="container mt-5">
  <h2 class="mb-4 text-center">
    Survey: Impact of Remote Work on Productivity
  </h2>
  <form id="surveyForm" action="submit_survey.php" method="POST">
    <div id="questionContainer"></div>

    <?php for ($i = 1; $i <= 10; $i++): ?>
      <input type="hidden" name="q<?= $i ?>" id="q<?= $i ?>Input">
    <?php endfor; ?>

    <div class="d-grid mt-3">
      <input type="submit" class="btn btn-primary d-none" id="submitBtn" value="submit" name="submit">
    </div>
  </form>

  <div id="responseMessage" class="mt-3"></div>
  <div class="mt-3">
    <button id="downloadPdfBtn" class="btn btn-outline-primary d-none">Download My Answers as PDF</button>
    <button id="rateUsBtn" class="btn btn-outline-warning ms-2 d-none">Rate Us</button>
  </div>

  <script src="script.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>