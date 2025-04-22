const questions = [
  {
      text: "1. Do you feel more productive while working remotely?",
      options: ["More productive", "Less productive", "No difference"],
  },
  {
      text: "2. How many days per week do you work remotely?",
      options: ["0-1 days", "2-3 days", "4-5 days", "Full-time remote"],
  },
  {
      text: "3. Do you find it easier to focus while working remotely?",
      options: ["Yes", "No", "Depends on the environment"],
  },
  {
      text: "4. How does remote work affect the number of tasks you complete in a day?",
      options: ["Increases", "Decreases", "No difference"],
  },
  {
      text: "5. What is the biggest challenge you face when working remotely?",
      options: [
          "Distractions",
          "Communication issues",
          "Lack of motivation",
          "Internet problems",
          "None",
      ],
  },
  {
      text: "6. How easy is it to collaborate with your team while working remotely?",
      options: ["Very easy", "Somewhat easy", "Difficult"],
  },
  {
      text: "7. Which communication tool do you use the most for remote work?",
      options: ["Zoom", "Slack", "Microsoft Teams", "Email", "Google Meet"],
  },
  {
      text: "8. Do you feel your work-life balance has improved since working remotely?",
      options: ["Yes", "No", "Somewhat"],
  },
  {
      text: "9. How often do you take breaks while working remotely?",
      options: ["Every hour", "Every few hours", "Rarely", "Never"],
  },
  {
      text: "10. Would you prefer to continue remote work in the future?",
      options: ["Yes", "No", "A mix of remote and office work"],
  },
];

let currentQuestion = 0;
const container = document.getElementById("questionContainer");
const submitBtn = document.getElementById("submitBtn");
const form = document.getElementById("surveyForm");
const responseMessage = document.getElementById("responseMessage");
const downloadBtn = document.getElementById("downloadPdfBtn");
const rateUsBtn = document.getElementById("rateUsBtn");
let answers = {};

function showQuestion(index) {
  container.innerHTML = "";
  const question = questions[index];
  const qNum = index + 1;

  const box = document.createElement("div");
  box.className = "question-box";

  const questionTitle = `
      <h5 class="text-primary">Question ${qNum}</h5>
      <label class="form-label fs-5">${question.text}</label>
  `;

  let inputs = "";
  question.options.forEach((opt, i) => {
      const id = `q${qNum}_${i}`;
      const nameAttr = `name="q${qNum}"`;
      const requiredAttr = "required";
      const isChecked = answers[`q${qNum}`] === opt;

      inputs += `
          <div class="radio-option form-check">
              <input type="radio" class="form-check-input me-2" id="${id}"
                      value="${opt}" ${nameAttr} ${requiredAttr} ${isChecked ? "checked" : ""
          }>
              <label class="form-check-label" for="${id}">${opt}</label>
          </div>
      `;
  });

  const nextBtn = `<button type="button" class="btn btn-primary mt-3" id="nextBtn">
                          ${index === questions.length - 1 ? "Submit" : "Next"}
                      </button>`;

  box.innerHTML = questionTitle + `<div class="ps-3">${inputs}</div>` + nextBtn;
  container.appendChild(box);

  document.getElementById("nextBtn").addEventListener("click", () => {
      const selected = document.querySelector(`input[name='q${qNum}']:checked`);
      if (selected) {
          answers[`q${qNum}`] = selected.value;
          document.getElementById(`q${qNum}Input`).value = selected.value;
      } else {
          alert("Please select an option to continue.");
          return;
      }

      currentQuestion++;
      if (currentQuestion < questions.length) {
          showQuestion(currentQuestion);
      } else {
          container.innerHTML = "";
          submitBtn.classList.remove("d-none");
      }
  });
}

// Start with first question
showQuestion(currentQuestion);

// Form submit
form.addEventListener("submit", function (e) {
  e.preventDefault();

  questions.forEach((question, index) => {
      const qNum = index + 1;
      const selectedRadio = document.querySelector(
          `input[name='q${qNum}']:checked`
      );
      if (selectedRadio) {
          answers[`q${qNum}`] = selectedRadio.value;
          const inputEl = document.getElementById(`q${qNum}Input`);
          if (inputEl) inputEl.value = selectedRadio.value;
      } else {
          currentQuestion = index;
          showQuestion(currentQuestion);
          e.stopImmediatePropagation();
          return;
      }
  });

  const formData = new FormData(form);

  fetch("submit_survey.php", {
      method: "POST",
      body: formData,
  })
      .then((response) => response.text())
      .then((data) => {
          responseMessage.innerHTML = `
              <div class="alert alert-success">${data}</div>
          `;
          form.reset();
          currentQuestion = 0;
          showQuestion(currentQuestion);
          submitBtn.classList.add("d-none");

          // Show download and rate us buttons
          downloadBtn.classList.remove("d-none");
          rateUsBtn.classList.remove("d-none");
      })
      .catch((error) => {
          responseMessage.innerHTML = `
              <div class="alert alert-danger">Submission failed. Please try again.</div>
          `;
          console.error("Error:", error);
      });
});

// Download PDF
downloadBtn.addEventListener("click", () => {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  let y = 10;
  doc.setFontSize(14);
  doc.text("Your Remote Work Survey Answers", 10, y);
  y += 10;

  questions.forEach((q, index) => {
      const qNum = index + 1;
      const answer = answers[`q${qNum}`] || "No answer";

      doc.setFontSize(11);
      doc.text(`${qNum}. ${q.text}`, 10, y);
      y += 6;

      doc.setFont("helvetica", "italic");
      doc.text(`Answer: ${answer}`, 12, y);
      doc.setFont("helvetica", "normal");
      y += 10;

      if (y > 270) {
          doc.addPage();
          y = 10;
      }
  });

  doc.save("survey_answers.pdf");
});

// Rate Us button click
rateUsBtn.addEventListener("click", () => {
  window.location.href = "rating.html";
});
