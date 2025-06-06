# 🎓 Student Grade Calculator

This project is a web-based application developed as a practical exam requirement using PHP. It allows a user to dynamically input assessment scores for multiple students, calculates their final grades based on a weighted formula, and displays the results in a clear, formatted report.

## ✨ Features

- **Add or Remove Students Easily**  
  Starts with one student form, but you can add or remove more anytime without reloading the page.

- **Grade Calculation**  
  - Averages 5 scores for Class Participation  
  - Averages 3 scores for Summative Assessments  
  - Uses this formula to compute the final grade:  
    ```
    Final Grade = (Class Participation * 30%) + (Summative * 30%) + (Final Exam * 40%)
    ```
  - Converts the final score into a letter grade (A, B, C, D, or F)

- **Results Table**  
  After submitting, you'll see a neat and responsive table showing all the students and their final grades.

- **Single-Page Application**  
  Everything from entering scores to seeing results happens on the same page for a smoother experience.
