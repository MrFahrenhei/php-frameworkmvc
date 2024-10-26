<?php

namespace App\Core;
/**
 * Class View
 *
 * @autor Vinícius Valle Beraldo <vvberaldo@proton.me>
 * @package App\Core
 */
class View
{
    public string $title = '';

    /**
     * @param $view
     * @param array $params
     * @return array|false|string
     */
    public function renderView($view, array $params = []): array|false|string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
    protected function renderContent(string $viewContent): array|false|string
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * @return false|string
     */
    protected function layoutContent(): false|string
    {
        $layout = Application::$app->layout;
        if(Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/layouts/{$layout}.php";
        return ob_get_clean();
    }

    /**
     * @param string $view
     * @param array $params
     * @return false|string
     */
    protected function renderOnlyView(string $view, array $params): false|string
    {
        foreach($params as $key => $value) {
            $$key  = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/src/Views/{$view}.php";
        return ob_get_clean();
    }
}