<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* category.twig */
class __TwigTemplate_c5df7e4304a8b9e6a852b19f411f02d0faf91a8d86ff88f1d22e9f3b1e7c6a97 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"ltr\" lang=\"en-gb\" xml:lang=\"en-gb\" data-ng-app>

<head>

    <meta charset=\"UTF-8\"/>
    <meta name=\"keywords\" content=\"\"/>
    <meta name=\"description\" content=\"\"/>
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"/>
    <link rel=\"shortcut icon\" href=\"./theme/images/favicon.ico\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">

    <title>";
        // line 13
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

    <link href=\"./theme/comboot/comboot.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/comboot/font-awesome.min.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/comboot/colorpicker.min.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/comboot/lightbox.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/comboot/select.min.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/comboot/syntax-highlighting.css\" rel=\"stylesheet\"/>
    <link href=\"./theme/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"./theme/bootstrap.min.css\" rel=\"stylesheet\">

    <script src=\"./theme/comboot/jquery.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/editor.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/angular.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/progressbar.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/bootstrap.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/colorpicker.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/lightbox.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/select.min.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/syntax-highlighting.js\" type=\"text/javascript\"></script>
    <script src=\"./theme/comboot/comboot.js\" type=\"text/javascript\"></script>


    <link href=\"./theme/fontawesome/css/all.min.css\" rel=\"stylesheet\"/>
    <script src=\"./theme/fontawesome/js/all.min.js\" type=\"text/javascript\"></script>


    <script src=\"https://code.jquery.com/jquery-3.3.1.slim.min.js\"
            integrity=\"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo\"
            crossorigin=\"anonymous\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js\"
            integrity=\"sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1\"
            crossorigin=\"anonymous\"></script>


</head>

<body class=\"section-index ltr\">

";
        // line 52
        $this->loadTemplate("header.twig", "category.twig", 52)->display($context);
        // line 53
        echo "
<div class=\"container\" id=\"content-wrapper\">
    ";
        // line 55
        $this->displayBlock('body', $context, $blocks);
        // line 58
        echo "</div>

</body>
</html>";
    }

    // line 13
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo "Foro Programacion &bull; - Categoria";
    }

    // line 55
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 56
        echo "        <p>Contingut per defecte</p>
    ";
    }

    public function getTemplateName()
    {
        return "category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 56,  117 => 55,  110 => 13,  103 => 58,  101 => 55,  97 => 53,  95 => 52,  53 => 13,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "category.twig", "/opt/lampp/htdocs/Projecte_Bloc_1/templates/category.twig");
    }
}
