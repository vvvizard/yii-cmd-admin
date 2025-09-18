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

    <div class="admin-bar" style="position:fixed; bottom:50px; width:80%">
        <div classs="container">
            <form id="admin-bar" action="/admin/cmd" method="POST">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                <div class="input-group">
                    <span class="input-group-text">With textarea</span>
                    <textarea id="cmd" name="cmd" class="form-control" aria-label="With textarea"></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">run</button>
                </div>
            </form>
        </div>
    </div>

    <script>

        function serializeForm(formNode) {
            console.log(formNode.elements)
            console.log(cmd)
            console.log(cmd.value)
        }

        function handleFormSubmit(event) {
            event.preventDefault();
            serializeForm(adminCli);
            const url = '/web/admin/cmd';
            const user = {
                "name": "Ivan Ivanov",
                "username": "ivan2002",
                "email": "ivan2002@mail.com",
            };
            const otherParam = {
                headers: {
                    "content-type": "application/json; charset=UTF-8",
                },
                body: JSON.stringify({"cmd" : cmd.value }),
                method: "POST",
            };

            fetch(url, otherParam)
                .then(data => data.json())
                .then(response => console.log(response))
                .catch(error => console.log(error));
            console.log('Отправка!')

                    adminCli.reset();
        }

        const adminCli = document.getElementById('admin-bar')

        const cmd = document.getElementById('cmd')
        
        
        adminCli.addEventListener('submit', handleFormSubmit)

    </script>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>