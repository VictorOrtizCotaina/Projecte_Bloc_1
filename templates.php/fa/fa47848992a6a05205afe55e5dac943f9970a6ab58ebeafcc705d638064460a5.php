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

/* header.twig */
class __TwigTemplate_2489263a955b9ed59dd236c8d0dba98cd4b7ad420bee1002b371cb5a04bf9c1c extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<header>
    <nav class=\"navbar navbar-default navbar-fixed-top navbar-fix\" id=\"header-nav\" role=\"navigation\">
        <div class=\"container-fluid\">

            <div id=\"search-menu\">
                <a class=\"navbar-brand\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Category", 1 => "index"], "method", false, false, false, 6), "html", null, true);
        echo "\">";
        echo gettext("Foro Programacion");
        echo "</a>

                ";
        // line 8
        if ( !twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 8)) {
            // line 9
            echo "                    <a class=\"btn navbar-form navbar-left ng-pristine ng-valid\"
                       href=\"";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "User", 1 => "login"], "method", false, false, false, 10), "html", null, true);
            echo "\">
                        <i class=\"fa fa-user\"></i>
                        ";
            // line 12
            echo gettext("Iniciar Sesión");
            // line 13
            echo "                    </a>
                    <a class=\"btn navbar-form navbar-left ng-pristine ng-valid\"
                       href=\"";
            // line 15
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "User", 1 => "register"], "method", false, false, false, 15), "html", null, true);
            echo "\">
                        <i class=\"fa fa-user-plus\"></i>
                        ";
            // line 17
            echo gettext("Registro");
            // line 18
            echo "                    </a>
                ";
        }
        // line 20
        echo "
                ";
        // line 21
        if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 21)) {
            // line 22
            echo "                    <a class=\"navbar-form navbar-left ng-pristine ng-valid\"
                       href=\"";
            // line 23
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "User", 1 => "getUser"], "method", false, false, false, 23), "html", null, true);
            echo "\">
                        ";
            // line 24
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "username", [], "any", false, false, false, 24), "html", null, true);
            echo "
                    </a>

                    ";
            // line 27
            if (twig_get_attribute($this->env, $this->source, ($context["session"] ?? null), "user", [], "any", false, false, false, 27)) {
                // line 28
                echo "                        <a class=\"navbar-form navbar-left ng-pristine ng-valid\"
                           href=\"";
                // line 29
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Category", 1 => "getAdminCategory"], "method", false, false, false, 29), "html", null, true);
                echo "\">
                            Back-Office
                        </a>
                    ";
            }
            // line 33
            echo "
                    <a class=\"btn navbar-form navbar-left ng-pristine ng-valid\" href=\"";
            // line 34
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "User", 1 => "logout"], "method", false, false, false, 34), "html", null, true);
            echo "\">
                        <i class=\"fas fa-power-off\"></i>
                        ";
            // line 36
            echo gettext("Cerrar Sesión");
            // line 37
            echo "                    </a>
                ";
        }
        // line 39
        echo "
                ";
        // line 40
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categoriesNavbar"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["categoryNavbar"]) {
            // line 41
            echo "                    <div class=\"btn-group\">
                        <div class=\"btn-group dropright\">
                            <a type=\"button\" class=\"btn btn-secondary\"
                               href=\"";
            // line 44
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Category", 1 => "getCategory", 2 => ["id_category" => twig_get_attribute($this->env, $this->source, $context["categoryNavbar"], "idCategory", [], "any", false, false, false, 44)]], "method", false, false, false, 44), "html", null, true);
            echo "\">
                                ";
            // line 45
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["categoryNavbar"], "title", [], "any", false, false, false, 45), "html", null, true);
            echo "
                            </a>
                            <button type=\"button\" class=\"btn btn-secondary dropdown-toggle dropdown-toggle-split\"
                                    data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                <span class=\"sr-only\">Toggle Dropright</span>
                            </button>
                            <ul class=\"dropdown-menu\">
                                ";
            // line 52
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["categoryNavbar"], "forums", [], "any", false, false, false, 52));
            foreach ($context['_seq'] as $context["_key"] => $context["forumNavbar"]) {
                // line 53
                echo "                                    <li><a href=\"";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Forum", 1 => "getForum", 2 => ["id_category" => twig_get_attribute($this->env, $this->source, $context["categoryNavbar"], "idCategory", [], "any", false, false, false, 53), "forumNavbar" => twig_get_attribute($this->env, $this->source, ($context["forum"] ?? null), "idForum", [], "any", false, false, false, 53)]], "method", false, false, false, 53), "html", null, true);
                echo "\">
                                            ";
                // line 54
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["forumNavbar"], "title", [], "any", false, false, false, 54), "html", null, true);
                echo "
                                        </a></li>
                                    <li class=\"divider\"></li>
                                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['forumNavbar'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 58
            echo "                            </ul>
                        </div>
                    </div>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['categoryNavbar'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "
                <div class=\"btn-group dropright\">
                    <button type=\"button\" class=\"btn btn-secondary dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        ";
        // line 65
        echo gettext("Idioma");
        // line 66
        echo "                    </button>
                    <div class=\"dropdown-menu\">
                        <a class=\"dropdown-item\" href=\"";
        // line 68
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Language", 1 => "changeLanguage", 2 => [], 3 => ["lang" => "es", "url" => ($context["url"] ?? null)]], "method", false, false, false, 68), "html", null, true);
        echo "\">Español</a>
                        <a class=\"dropdown-item\" href=\"";
        // line 69
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Language", 1 => "changeLanguage", 2 => [], 3 => ["lang" => "ca", "url" => ($context["url"] ?? null)]], "method", false, false, false, 69), "html", null, true);
        echo "\">Catalan</a>
                        <a class=\"dropdown-item\" href=\"";
        // line 70
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Language", 1 => "changeLanguage", 2 => [], 3 => ["lang" => "en", "url" => ($context["url"] ?? null)]], "method", false, false, false, 70), "html", null, true);
        echo "\">Ingles</a>
                    </div>
                </div>

            </div>

        </div>
    </nav>

    <div class=\"jumbotron no-margin-bottom no-padding-bottom\">
        <div class=\"container text-center\">
            <div id=\"site-logo\"><a href=\"";
        // line 81
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Category", 1 => "index"], "method", false, false, false, 81), "html", null, true);
        echo "\"
                                   title=\"Board index\"><h2>Foro Programacion</h2></a></div>

        </div>
    </div>
</header>";
    }

    public function getTemplateName()
    {
        return "header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  209 => 81,  195 => 70,  191 => 69,  187 => 68,  183 => 66,  181 => 65,  176 => 62,  167 => 58,  157 => 54,  152 => 53,  148 => 52,  138 => 45,  134 => 44,  129 => 41,  125 => 40,  122 => 39,  118 => 37,  116 => 36,  111 => 34,  108 => 33,  101 => 29,  98 => 28,  96 => 27,  90 => 24,  86 => 23,  83 => 22,  81 => 21,  78 => 20,  74 => 18,  72 => 17,  67 => 15,  63 => 13,  61 => 12,  56 => 10,  53 => 9,  51 => 8,  44 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.twig", "/opt/lampp/htdocs/Projecte_Bloc_1/templates/header.twig");
    }
}
