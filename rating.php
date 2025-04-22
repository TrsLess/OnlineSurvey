<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Our Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            font-size: 2em;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            cursor: pointer;
        }

        .star-rating input:checked~label {
            color: #ffc107;
        }

        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #ffc107;
        }

        .thank-you {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body class="container mt-5">
    <h2 class="mb-4 text-center">Rate Our Survey</h2>

    <?php
    if (isset($_GET['rating_success']) && $_GET['rating_success'] == 1) {
        echo '<div class="alert alert-success text-center">Thank you for your rating!</div>';
    } else {
        ?>
        <form action="submit_rating.php" method="POST" class="text-center">
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars"><i
                        class="fas fa-star"></i></label>
                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i
                        class="fas fa-star"></i></label>
                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i
                        class="fas fa-star"></i></label>
                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i
                        class="fas fa-star"></i></label>
                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i
                        class="fas fa-star"></i></label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit Rating</button>
        </form>
    <?php } ?>

    <div class="mt-3 text-center">
        <a href="index.php" class="btn btn-secondary">Go Back to Survey</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>