<?php

use App\Core\Application;

$this->title = 'Profile';
?>

<h1>Profile page</h1>
<h1> Hello <?= Application::$app->user->getDisplayName(); ?> </h1>
