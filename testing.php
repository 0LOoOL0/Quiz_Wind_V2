<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
    <style>
        .popup-create {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
        }
        .popup-content {
            margin-bottom: 20px;
        }
        .remove-button {
            color: red;
            cursor: pointer;
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div id="question-container">
    <div class="popup-create2">
        <form action="Includes/Question_handler.php" method="post">
            <div class="popup-content2">
                <h1><label for="question">Create Question</label></h1>
                <table>
                    <tr>
                        <td style='width:40px;'><label for="questionText">Question:</label></td>
                        <td><input type="text" name="questionText[]" required></td>
                    </tr>
                </table>
                <div class="crud-option">
                    <table>
                        <tr>
                            <td style='width:20px;'><label>Option:</label></td>
                            <td>
                                <input type="text" name="optionTexts[]" required />
                            </td>
                        </tr>
                        <tr>
                            <td style='width:20px;'><label>Correct answer:</label></td>
                            <td>
                                <select style='width:300px; height:30px; border-radius:5px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
                                    <option value="">Select correct Answer....</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

<button id="add-question">Add Another Question</button>

<script>
    let questionCount = 1;

    document.getElementById('add-question').addEventListener('click', function () {
        const container = document.getElementById('question-container');

        const newPopup = document.createElement('div');
        newPopup.className = 'popup-create2';
        newPopup.innerHTML = `
            <form action="Includes/Question_handler.php" method="post">
                <div class="popup-content">
                    <h1><label for="question">Create Question</label></h1>
                    <table>
                        <tr>
                            <td style='width:40px;'><label for="questionText">Question:</label></td>
                            <td><input type="text" name="questionText[]" required></td>
                        </tr>
                    </table>
                    <div class="crud-option">
                        <table>
                            <tr>
                                <td style='width:20px;'><label>Option:</label></td>
                                <td>
                                    <input type="text" name="optionTexts[]" required />
                                </td>
                            </tr>
                            <tr>
                                <td style='width:20px;'><label>Correct answer:</label></td>
                                <td>
                                    <select style='width:300px; height:30px; border-radius:5px; margin-left: 10px; margin-top:20px;' name="isCorrect[]">
                                        <option value="">Select correct Answer....</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <span class="remove-button" onclick="this.parentElement.parentElement.parentElement.remove()">Remove</span>
                </div>
            </form>
        `;

        container.appendChild(newPopup);
        questionCount++;
    });
</script>

</body>
</html>