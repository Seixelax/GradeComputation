<?php
/* 
    Program: Computation of Grades using Functions
    Programmer: Alexies Hyro Pepito
    Section: AN21
    Start Date: June 5, 2025
    End Date: June 7, 2025
*/

function calculateAverage(array $assessments): float {
    $numericAssessments = array_map('floatval', $assessments);
    $total = array_sum($numericAssessments);
    $count = count($numericAssessments);
    return $count > 0 ? $total / $count : 0;
}

function calculateFinalGrade(float $classParticipation, float $summativeAssessment, float $finalExam): float {
    return ($classParticipation * 0.30) + ($summativeAssessment * 0.30) + ($finalExam * 0.40);
}

function determineLetterGrade(float $gradeScore): string {
    if ($gradeScore >= 90) return 'A';
    if ($gradeScore >= 80) return 'B';
    if ($gradeScore >= 70) return 'C';
    if ($gradeScore >= 60) return 'D';
    return 'F';
}

$studentRecords = [];
$isFormSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calculate'])) {
    $isFormSubmitted = true;
    
    $studentNames = $_POST['student_names'] ?? [];
    $enablingScores = $_POST['enabling'] ?? [];
    $summativeScores = $_POST['summative'] ?? [];
    $examGrades = $_POST['exam_grades'] ?? [];

    $numberOfStudents = count($studentNames);

    for ($i = 0; $i < $numberOfStudents; $i++) {
        $classParticipation = calculateAverage($enablingScores[$i]);
        $summativeGrade = calculateAverage($summativeScores[$i]);
        $finalGradeScore = calculateFinalGrade($classParticipation, $summativeGrade, (float)$examGrades[$i]);
        $letterGrade = determineLetterGrade($finalGradeScore);

        $studentRecords[] = [
            'name' => $studentNames[$i],
            'classParticipation' => round($classParticipation),
            'summativeAssessment' => round($summativeGrade),
            'examGrade' => $examGrades[$i],
            'gradeScore' => round($finalGradeScore),
            'letterGrade' => $letterGrade
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
        h1, h2 {
            text-align: center;
            color: #1d3557;
            border-bottom: 2px solid #e63946;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }

        .student-form-block {
            margin-bottom: 25px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fdfdfd;
            position: relative;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 15px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: 600;
            color: #457b9d;
        }
        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .btn, .submit-btn {
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            margin-top: 15px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .add-btn { background-color: #2a9d8f; }
        .add-btn:hover { background-color: #268a7e; }
        .remove-btn {
            background-color: #e76f51;
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
        }
        .submit-btn { width: 100%; background-color: #e63946; font-size: 1.2rem; }
        .submit-btn:hover { background-color: #d0313f; }
        .button-group { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px 15px; text-align: center; border: 1px solid #ddd; }
        th { background-color: #1d3557; color: white; }
        td:first-child { text-align: left; }
        tr:nth-child(even) { background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="container">
    <h1>Student Grade</h1>

    <?php if ($isFormSubmitted): ?>
        <div class="results-container">
            <h2>Final Grade Report</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name of Student</th>
                        <th>Class Part.</th>
                        <th>Summative</th>
                        <th>Exam Grade</th>
                        <th>Grade Score</th>
                        <th>Letter Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentRecords as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['name']); ?></td>
                            <td><?php echo $record['classParticipation']; ?></td>
                            <td><?php echo $record['summativeAssessment']; ?></td>
                            <td><?php echo $record['examGrade']; ?></td>
                            <td><?php echo $record['gradeScore']; ?></td>
                            <td><?php echo $record['letterGrade']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="btn add-btn" style="width: calc(100% - 40px);">Calculate New Grades</a>
        </div>
    <?php else: ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div id="student-forms-container">
                <div class="student-form-block">
                    <h2>Student 1</h2>
                    <div class="form-group" style="grid-column: 1 / -1;">
                        <label>Student Name</label>
                        <input type="text" name="student_names[]" required>
                    </div>
                    <p><b>Enabling Assessments (5)</b></p>
                    <div class="form-grid">
                        <?php for ($j = 0; $j < 5; $j++): ?>
                            <div class="form-group"><label>EA <?php echo $j + 1; ?></label><input type="number" name="enabling[0][]" min="0" max="100" required></div>
                        <?php endfor; ?>
                    </div>
                    <p><b>Summative Assessments (3)</b></p>
                    <div class="form-grid">
                        <?php for ($k = 0; $k < 3; $k++): ?>
                            <div class="form-group"><label>SA <?php echo $k + 1; ?></label><input type="number" name="summative[0][]" min="0" max="100" required></div>
                        <?php endfor; ?>
                    </div>
                    <p><b>Final Examination</b></p>
                    <div class="form-grid"><div class="form-group"><label>Major Exam Grade</label><input type="number" name="exam_grades[]" min="0" max="100" required></div></div>
                </div>
            </div>

            <div class="button-group">
                <button type="button" id="add-student-btn" class="btn add-btn">Add Another Student</button>
            </div>
            
            <button type="submit" name="calculate" class="submit-btn">Calculate Grades</button>
        </form>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addStudentBtn = document.getElementById('add-student-btn');
    if (!addStudentBtn) {
        return;
    }

    const formsContainer = document.getElementById('student-forms-container');
    let studentCounter = 1;

    addStudentBtn.addEventListener('click', function () {
        studentCounter++;

        const newFormBlock = document.createElement('div');
        newFormBlock.className = 'student-form-block';
        newFormBlock.innerHTML = `
            <h2>Student ${studentCounter}</h2>
            <button type="button" class="btn remove-btn">Remove</button>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Student Name</label>
                <input type="text" name="student_names[]" required>
            </div>
            <p><b>Enabling Assessments (5)</b></p>
            <div class="form-grid">
                ${Array(5).fill(0).map((_, j) => `
                    <div class="form-group">
                        <label>EA ${j + 1}</label>
                        <input type="number" name="enabling[${studentCounter - 1}][]" min="0" max="100" required>
                    </div>`).join('')}
            </div>
            <p><b>Summative Assessments (3)</b></p>
            <div class="form-grid">
                ${Array(3).fill(0).map((_, k) => `
                    <div class="form-group">
                        <label>SA ${k + 1}</label>
                        <input type="number" name="summative[${studentCounter - 1}][]" min="0" max="100" required>
                    </div>`).join('')}
            </div>
            <p><b>Final Examination</b></p>
            <div class="form-grid">
                <div class="form-group">
                    <label>Major Exam Grade</label>
                    <input type="number" name="exam_grades[]" min="0" max="100" required>
                </div>
            </div>`;
        
        formsContainer.appendChild(newFormBlock);

        newFormBlock.querySelector('.remove-btn').addEventListener('click', function() {
            this.closest('.student-form-block').remove();
        });
    });
});
</script>
</body>
</html>