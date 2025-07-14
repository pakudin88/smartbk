<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title><?= esc($title) ?></title>
    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: 0.8;
            font-size: 3rem;
            color: #222;
            margin: 0;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        pre {
            white-space: pre-wrap;
            background: #f9f9f9;
            border: 1px solid #efefef;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: left;
            font-family: Consolas, Monaco, Courier, monospace;
            color: #333;
        }
        .footer {
            margin-top: 2rem;
            border-top: 1px solid #efefef;
            padding-top: 1rem;
            font-size: 0.85rem;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Something's not quite right.</h1>

        <p>The page you are looking for could not be found.</p>

        <?php if (ENVIRONMENT !== 'production') : ?>
            <div class="footer">
                <p>
                    Displayed at <?= date('H:i:sa') ?> &mdash;
                    PHP: <?= phpversion() ?>  &mdash;
                    CodeIgniter: <?= \CodeIgniter\CodeIgniter::CI_VERSION ?>
                </p>
            </div>
        <?php endif ?>
    </div>
</body>
</html>
