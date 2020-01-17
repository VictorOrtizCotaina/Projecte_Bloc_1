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

/* show.category.twig */
class __TwigTemplate_64ff17ae7865292efe6e4376adce41609d7f301b85cab3e5fdb7b4d2c5e9bf8e extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "category.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("category.twig", "show.category.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    ";
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "
";
    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        echo "    <div class=\"page-header\">
        <h2>";
        // line 7
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "title", [], "any", false, false, false, 7), "html", null, true);
        echo "</h2>
    </div>

    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "forums", [], "any", false, false, false, 10));
        foreach ($context['_seq'] as $context["_key"] => $context["forum"]) {
            // line 11
            echo "        <div class=\"table-responsive\">
            <table class=\"table table-striped table-bordered\">
                <thead class=\"topiclist\">
                <tr>
                    <th class=\"forum-name\"><i class=\"fa fa-folder-open\"></i>Forum</th>
                    <th class=\"topics\"><i class=\"fa fa-comments-o\"></i>Topics</th>
                    <th class=\"posts\"><i class=\"fa fa-pencil-square-o\"></i>Posts</th>
                    <th class=\"lastpost\"><i class=\"fa fa-history\"></i> <span> Last post</span></th>
                </tr>
                </thead>
                <tbody class=\"topiclist forums\">

                <tr>
                    <td class=\"forum-name\" title=\"No unread posts\">
\t\t\t\t\t\t<span class=\"pull-left forum-icon\">
\t\t\t\t\t\t\t<a href=\"";
            // line 26
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Forum", 1 => "getForum", 2 => ["id_category" => twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "idCategory", [], "any", false, false, false, 26), "id_forum" => twig_get_attribute($this->env, $this->source, $context["forum"], "idForum", [], "any", false, false, false, 26)]], "method", false, false, false, 26), "html", null, true);
            echo "\"
                               class=\"btn btn-lg btn-default tooltip-link\" title=\"No unread posts\">
                                <div class=\"\">
                                    <img width=\"32\" height=\"32\" src=\"";
            // line 29
            echo twig_escape_filter($this->env, ($context["target_dir"] ?? null), "html", null, true);
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["forum"], "image", [], "any", false, false, false, 29), "html", null, true);
            echo "\">
                                </div>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</span>
                        <div class=\"forum-icon-mobile\">

                            <i class=\"fa fa-folder fa-fw\"></i>

                        </div>
                        <a href=\"";
            // line 38
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["router"] ?? null), "generateURL", [0 => "Forum", 1 => "getForum", 2 => ["id_category" => twig_get_attribute($this->env, $this->source, ($context["category"] ?? null), "idCategory", [], "any", false, false, false, 38), "id_forum" => twig_get_attribute($this->env, $this->source, $context["forum"], "idForum", [], "any", false, false, false, 38)]], "method", false, false, false, 38), "html", null, true);
            echo "\"
                           class=\"forumtitle\">";
            // line 39
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["forum"], "title", [], "any", false, false, false, 39), "html", null, true);
            echo "</a><br/>
                        <small>";
            // line 40
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["forum"], "description", [], "any", false, false, false, 40), "html", null, true);
            echo "</small>

                    </td>
                    <td><span class=\"badge\">No esta implementado</span></td>
                    <td><span class=\"badge\">No esta implementado</span></td>
                    <td><span class=\"badge\">No esta implementado</span></td>

                </tr>

                </tbody>
            </table>
        </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['forum'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "
";
    }

    public function getTemplateName()
    {
        return "show.category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 53,  119 => 40,  115 => 39,  111 => 38,  98 => 29,  92 => 26,  75 => 11,  71 => 10,  65 => 7,  62 => 6,  58 => 5,  51 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "show.category.twig", "/opt/lampp/htdocs/Projecte_Bloc_1/templates/show.category.twig");
    }
}
