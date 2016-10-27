<?php

/* themes/custom/shopsPlus/templates/page.html.twig */
class __TwigTemplate_7829a2d9a46ebc6af8016a7003c56a9fccea43c097c963a74545df21cb02cdc4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("set" => 1, "if" => 13);
        $filters = array("render" => 1);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if'),
                array('render'),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setTemplateFile($this->getTemplateName());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 1
        $context["main_menu"] = $this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "primary_menu", array()));
        // line 2
        $context["secondary_menu"] = $this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "secondary_menu", array()));
        // line 3
        echo "<div";
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => "layout-container", 1 => (((        // line 5
(isset($context["main_menu"]) ? $context["main_menu"] : null) || (isset($context["secondary_menu"]) ? $context["secondary_menu"] : null))) ? ("with-navigation") : ("")), 2 => ((        // line 6
(isset($context["secondary_menu"]) ? $context["secondary_menu"] : null)) ? ("with-subnav") : (""))), "method"), "html", null, true));
        // line 7
        echo ">

  <!-- ______________________ HEADER _______________________ -->

  <header id=\"header\">
    <div class=\"container\">
      ";
        // line 13
        if ($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header", array())) {
            // line 14
            echo "        <div id=\"header-region\">
          ";
            // line 15
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "header", array()), "html", null, true));
            echo "
        </div>
      ";
        }
        // line 18
        echo "    </div>
  </header><!-- /#header -->

  ";
        // line 21
        if (((isset($context["main_menu"]) ? $context["main_menu"] : null) || (isset($context["secondary_menu"]) ? $context["secondary_menu"] : null))) {
            // line 22
            echo "    <nav id=\"navigation\" class=\"menu";
            if ((isset($context["main_menu"]) ? $context["main_menu"] : null)) {
                echo " with-primary";
            }
            if ((isset($context["secondary_menu"]) ? $context["secondary_menu"] : null)) {
                echo " with-secondary";
            }
            echo "\">
      <div class=\"container\">
        ";
            // line 24
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["main_menu"]) ? $context["main_menu"] : null), "html", null, true));
            echo "
        ";
            // line 25
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["secondary_menu"]) ? $context["secondary_menu"] : null), "html", null, true));
            echo "
      </div>
    </nav><!-- /#navigation -->
  ";
        }
        // line 29
        echo "
  <!-- ______________________ MAIN _______________________ -->

  <div id=\"main\">
    <div class=\"container\">
      <section id=\"content\">

        <div id=\"content-header\">

          ";
        // line 38
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "breadcrumb", array()), "html", null, true));
        echo "

          ";
        // line 40
        if ($this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "highlighted", array()))) {
            // line 41
            echo "            <div id=\"highlighted\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "highlighted", array()), "html", null, true));
            echo "</div>
          ";
        }
        // line 43
        echo "
          ";
        // line 44
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
        echo "

          ";
        // line 46
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 47
            echo "            <h1 class=\"title\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true));
            echo "</h1>
          ";
        }
        // line 49
        echo "
          ";
        // line 50
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
        echo "
          ";
        // line 51
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "help", array()), "html", null, true));
        echo "

          ";
        // line 53
        if ((isset($context["tabs"]) ? $context["tabs"] : null)) {
            // line 54
            echo "            <div class=\"tabs\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["tabs"]) ? $context["tabs"] : null), "html", null, true));
            echo "</div>
          ";
        }
        // line 56
        echo "
          ";
        // line 57
        if ((isset($context["action_links"]) ? $context["action_links"] : null)) {
            // line 58
            echo "            <ul class=\"action-links\">";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["action_links"]) ? $context["action_links"] : null), "html", null, true));
            echo "</ul>
          ";
        }
        // line 60
        echo "
        </div><!-- /#content-header -->

        <div id=\"content-area\">
          ";
        // line 64
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), "html", null, true));
        echo "
        </div>

      </section><!-- /#content -->

      ";
        // line 69
        if ($this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_first", array()))) {
            // line 70
            echo "        <aside id=\"sidebar-first\" class=\"column sidebar first\">
          ";
            // line 71
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_first", array()), "html", null, true));
            echo "
        </aside><!-- /#sidebar-first -->
      ";
        }
        // line 74
        echo "
      ";
        // line 75
        if ($this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_second", array()))) {
            // line 76
            echo "        <aside id=\"sidebar-second\" class=\"column sidebar second\">
          ";
            // line 77
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "sidebar_second", array()), "html", null, true));
            echo "
        </aside><!-- /#sidebar-second -->
      ";
        }
        // line 80
        echo "    </div><!-- /.container -->
  </div><!-- /#main -->

  <!-- ______________________ FOOTER _______________________ -->

  ";
        // line 85
        if ($this->env->getExtension('drupal_core')->renderVar($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "footer", array()))) {
            // line 86
            echo "    <footer id=\"footer\">
      <div class=\"container\">
        ";
            // line 88
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "footer", array()), "html", null, true));
            echo "
      </div>
    </footer><!-- /#footer -->
  ";
        }
        // line 92
        echo "
</div><!-- /.layout-container -->
";
    }

    public function getTemplateName()
    {
        return "themes/custom/shopsPlus/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  230 => 92,  223 => 88,  219 => 86,  217 => 85,  210 => 80,  204 => 77,  201 => 76,  199 => 75,  196 => 74,  190 => 71,  187 => 70,  185 => 69,  177 => 64,  171 => 60,  165 => 58,  163 => 57,  160 => 56,  154 => 54,  152 => 53,  147 => 51,  143 => 50,  140 => 49,  134 => 47,  132 => 46,  127 => 44,  124 => 43,  118 => 41,  116 => 40,  111 => 38,  100 => 29,  93 => 25,  89 => 24,  78 => 22,  76 => 21,  71 => 18,  65 => 15,  62 => 14,  60 => 13,  52 => 7,  50 => 6,  49 => 5,  47 => 3,  45 => 2,  43 => 1,);
    }
}
/* {% set main_menu = page.primary_menu|render %}*/
/* {% set secondary_menu = page.secondary_menu|render %}*/
/* <div{{ attributes.addClass(*/
/*   'layout-container',*/
/*   main_menu or secondary_menu ? 'with-navigation',*/
/*   secondary_menu ? 'with-subnav'*/
/* ) }}>*/
/* */
/*   <!-- ______________________ HEADER _______________________ -->*/
/* */
/*   <header id="header">*/
/*     <div class="container">*/
/*       {% if page.header %}*/
/*         <div id="header-region">*/
/*           {{ page.header }}*/
/*         </div>*/
/*       {% endif %}*/
/*     </div>*/
/*   </header><!-- /#header -->*/
/* */
/*   {% if main_menu or secondary_menu %}*/
/*     <nav id="navigation" class="menu{% if main_menu %} with-primary{% endif %}{% if secondary_menu %} with-secondary{% endif %}">*/
/*       <div class="container">*/
/*         {{ main_menu }}*/
/*         {{ secondary_menu }}*/
/*       </div>*/
/*     </nav><!-- /#navigation -->*/
/*   {% endif %}*/
/* */
/*   <!-- ______________________ MAIN _______________________ -->*/
/* */
/*   <div id="main">*/
/*     <div class="container">*/
/*       <section id="content">*/
/* */
/*         <div id="content-header">*/
/* */
/*           {{ page.breadcrumb }}*/
/* */
/*           {% if page.highlighted|render %}*/
/*             <div id="highlighted">{{ page.highlighted }}</div>*/
/*           {% endif %}*/
/* */
/*           {{ title_prefix }}*/
/* */
/*           {% if title %}*/
/*             <h1 class="title">{{ title }}</h1>*/
/*           {% endif %}*/
/* */
/*           {{ title_suffix }}*/
/*           {{ page.help }}*/
/* */
/*           {% if tabs %}*/
/*             <div class="tabs">{{ tabs }}</div>*/
/*           {% endif %}*/
/* */
/*           {% if action_links %}*/
/*             <ul class="action-links">{{ action_links }}</ul>*/
/*           {% endif %}*/
/* */
/*         </div><!-- /#content-header -->*/
/* */
/*         <div id="content-area">*/
/*           {{ page.content }}*/
/*         </div>*/
/* */
/*       </section><!-- /#content -->*/
/* */
/*       {% if page.sidebar_first|render %}*/
/*         <aside id="sidebar-first" class="column sidebar first">*/
/*           {{ page.sidebar_first }}*/
/*         </aside><!-- /#sidebar-first -->*/
/*       {% endif %}*/
/* */
/*       {% if page.sidebar_second|render %}*/
/*         <aside id="sidebar-second" class="column sidebar second">*/
/*           {{ page.sidebar_second }}*/
/*         </aside><!-- /#sidebar-second -->*/
/*       {% endif %}*/
/*     </div><!-- /.container -->*/
/*   </div><!-- /#main -->*/
/* */
/*   <!-- ______________________ FOOTER _______________________ -->*/
/* */
/*   {% if page.footer|render %}*/
/*     <footer id="footer">*/
/*       <div class="container">*/
/*         {{ page.footer }}*/
/*       </div>*/
/*     </footer><!-- /#footer -->*/
/*   {% endif %}*/
/* */
/* </div><!-- /.layout-container -->*/
/* */
