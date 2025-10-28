<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav'],
            'items' => [
                ['label' => 'Хоум', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
                Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ]
        ]);
        NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => 'старт', 'url' => Yii::$app->homeUrl],
                    'links' => $this->params['breadcrumbs']
                ]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <div class="admin-bar">
        <div classs="container">
            <form id="admin-bar" action="/admin/cmd" method="POST">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="input-group">
                    <textarea id="cmd" name="cmd" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" class="form-control" aria-label="With textarea"></textarea>
                    <span class="input-group-text bg-dark"><button type="submit"
                            class="btn btn-primary">>></button></span>
                </div>
            </form>
        </div>
    </div>

    <div id="output-window">
        <span id="close-output-window">X</span>
    </div>

    <style>
        .admin-bar {
            position: fixed;
            bottom: 50px;
            width: 100%
        }

        .admin-bar textarea,
        .admin-bar textarea:focus {
            background-color: black;
            color: greenyellow;
            border: none;
            box-shadow: none;
            height: 186px;
        }

        #output-window {
            background-color: black;
            color: white;
            height: 60%;
            width: 80%;
            border: 2px solid green;
            margin-left: 10%;
            position: fixed;
            top: 100px;
            overflow-y: auto;
        }

        #close-output-window {
            display: block;
            border: 1px solid green;
            width: 35px;
            color: green;
            text-align: center;
            position: relative;
            left: 95%;
            cursor: default;
        }
    </style>

    <script>

        function serializeForm(formNode) {
            console.log(formNode.elements)
            console.log(cmd)
            console.log(cmd.value)
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            serializeForm(adminCli);
            const url = '/web/admin-cmd/cmd';
            const user = {
                "name": "Ivan Ivanov",
                "username": "ivan2002",
                "email": "ivan2002@mail.com",
            };

            let Command = cmd.value.split("\n").pop();

            const param = {
                headers: {
                    "content-type": "application/json; charset=UTF-8",
                },
                body: JSON.stringify({ "cmd": Command }),
                method: "POST",
            };

            fetch(url, param)
                .then(data => data.json())
                .then(response => handleResponse(response))
                .catch(error => console.log(error));
            console.log('Отправка!')
            // adminCli.reset();
            // terminalText('Command sent');
        }


        function handleResponse(response) {
            if (response.terminalMessage != '') {
                terminalText(response.terminalMessage)
            }

            if( response.jsCommand != ''){
                eval(response.jsCommand)
            }
        }

        function terminalText(text) {
            let cmd = document.getElementById("cmd");
            cmd.value += '\r\n' + text + '\r\n';
            cmd.scrollTop = cmd.scrollHeight;
        }

        const adminCli = document.getElementById('admin-bar')

        const cmd = document.getElementById('cmd')
        adminCli.onkeydown = function (e) {
            if (e.keyCode == 13) {
                handleFormSubmit(e);

            }
        };

        adminCli.addEventListener('submit', handleFormSubmit)

        const outputWindow = document.getElementById('output-window');
        function closeOutputWindow() {
            outputWindow.style.display = 'none';
        }

        function openOutputWindow() {
            outputWindow.style.display = 'block';
        }

        const closeOutputWindowBtn = document.getElementById('close-output-window')
        closeOutputWindowBtn.addEventListener('click', closeOutputWindow)

    </script>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>