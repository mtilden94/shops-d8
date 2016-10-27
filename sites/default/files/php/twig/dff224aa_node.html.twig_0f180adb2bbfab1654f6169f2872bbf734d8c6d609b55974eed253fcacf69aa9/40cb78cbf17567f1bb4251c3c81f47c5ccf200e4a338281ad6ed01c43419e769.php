<?php

/* themes/custom/shopsPlus/templates/node.html.twig */
class __TwigTemplate_495b2a4aad8ed9b524941b60fca8f422f76221133686d36488921aefb35c2ac0 extends Twig_Template
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
        $tags = array("set" => 2, "if" => 19, "trans" => 32);
        $filters = array("t" => 38, "without" => 44);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set', 'if', 'trans'),
                array('t', 'without'),
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

        // line 2
        $context["classes"] = array(0 => "node");
        // line 5
        echo "
";
        // line 16
        echo "
<article";
        // line 17
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => (isset($context["classes"]) ? $context["classes"] : null)), "method"), "html", null, true));
        echo ">

  ";
        // line 19
        if ((((((isset($context["title_prefix"]) ? $context["title_prefix"] : null) || (isset($context["title_suffix"]) ? $context["title_suffix"] : null)) || (isset($context["display_submitted"]) ? $context["display_submitted"] : null)) || (isset($context["unpublished"]) ? $context["unpublished"] : null)) || (twig_test_empty((isset($context["page"]) ? $context["page"] : null)) && (isset($context["label"]) ? $context["label"] : null)))) {
            // line 20
            echo "    <header>
      ";
            // line 21
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_prefix"]) ? $context["title_prefix"] : null), "html", null, true));
            echo "
      ";
            // line 22
            if (( !(isset($context["page"]) ? $context["page"] : null) && (isset($context["label"]) ? $context["label"] : null))) {
                // line 23
                echo "        <h2";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["title_attributes"]) ? $context["title_attributes"] : null), "addClass", array(0 => (isset($context["title_classes"]) ? $context["title_classes"] : null)), "method"), "html", null, true));
                echo ">
          <a href=\"";
                // line 24
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true));
                echo "\" rel=\"bookmark\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["label"]) ? $context["label"] : null), "html", null, true));
                echo "</a>
        </h2>
      ";
            }
            // line 27
            echo "      ";
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["title_suffix"]) ? $context["title_suffix"] : null), "html", null, true));
            echo "

      ";
            // line 29
            if ((isset($context["display_submitted"]) ? $context["display_submitted"] : null)) {
                // line 30
                echo "        <div class=\"submitted\">
          ";
                // line 31
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["author_picture"]) ? $context["author_picture"] : null), "html", null, true));
                echo "
          ";
                // line 32
                echo t("Submitted by @author_name on @date", array("@author_name" => (isset($context["author_name"]) ? $context["author_name"] : null), "@date" => (isset($context["date"]) ? $context["date"] : null), ));
                // line 33
                echo "          ";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, (isset($context["metadata"]) ? $context["metadata"] : null), "html", null, true));
                echo "
        </div>
      ";
            }
            // line 36
            echo "
      ";
            // line 37
            if ( !$this->getAttribute((isset($context["node"]) ? $context["node"] : null), "published", array())) {
                // line 38
                echo "        <p class=\"node--unpublished\">";
                echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->renderVar(t("Unpublished")));
                echo "</p>
      ";
            }
            // line 40
            echo "    </header>
  ";
        }
        // line 42
        echo "
  <div";
        // line 43
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content_attributes"]) ? $context["content_attributes"] : null), "addClass", array(0 => "content"), "method"), "html", null, true));
        echo ">
    ";
        // line 44
        echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, twig_without((isset($context["content"]) ? $context["content"] : null), "links"), "html", null, true));
        echo "
  </div><!-- /.content -->

  ";
        // line 47
        if ($this->getAttribute((isset($context["content"]) ? $context["content"] : null), "links", array())) {
            // line 48
            echo "    <div class=\"links\">
      ";
            // line 49
            echo $this->env->getExtension('sandbox')->ensureToStringAllowed($this->env->getExtension('drupal_core')->escapeFilter($this->env, $this->getAttribute((isset($context["content"]) ? $context["content"] : null), "links", array()), "html", null, true));
            echo "
    </div><!-- /.links -->
  ";
        }
        // line 52
        echo "
</article><!-- /.node -->
";
    }

    public function getTemplateName()
    {
        return "themes/custom/shopsPlus/templates/node.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 52,  137 => 49,  134 => 48,  132 => 47,  126 => 44,  122 => 43,  119 => 42,  115 => 40,  109 => 38,  107 => 37,  104 => 36,  97 => 33,  95 => 32,  91 => 31,  88 => 30,  86 => 29,  80 => 27,  72 => 24,  67 => 23,  65 => 22,  61 => 21,  58 => 20,  56 => 19,  51 => 17,  48 => 16,  45 => 5,  43 => 2,);
    }
}
/* {# Create classes array. The 'node' class is required for contextual edit links. #}*/
/* {% set classes = [*/
/*   'node'*/
/* ] %}*/
/* */
/* {# BEM inspired class syntax: https://en.bem.info/*/
/*    Enable this code if you would like node classes like "article article--layout-teaser", where article is the content type and teaser is the view mode.*/
/* {% set classes = classes|merge([*/
/*   node.bundle|clean_class,*/
/*   view_mode ? node.bundle|clean_class ~ '--layout-' ~ view_mode|clean_class*/
/* ]) %}*/
/* {% set title_classes = [*/
/*   node.bundle|clean_class ~ '__title'*/
/* ] %}*/
/* #}*/
/* */
/* <article{{ attributes.addClass(classes) }}>*/
/* */
/*   {% if title_prefix or title_suffix or display_submitted or unpublished or page is empty and label %}*/
/*     <header>*/
/*       {{ title_prefix }}*/
/*       {% if not page and label %}*/
/*         <h2{{ title_attributes.addClass(title_classes) }}>*/
/*           <a href="{{ url }}" rel="bookmark">{{ label }}</a>*/
/*         </h2>*/
/*       {% endif %}*/
/*       {{ title_suffix }}*/
/* */
/*       {% if display_submitted %}*/
/*         <div class="submitted">*/
/*           {{ author_picture }}*/
/*           {% trans %}Submitted by {{ author_name }} on {{ date }}{% endtrans %}*/
/*           {{ metadata }}*/
/*         </div>*/
/*       {% endif %}*/
/* */
/*       {% if not node.published %}*/
/*         <p class="node--unpublished">{{ 'Unpublished'|t }}</p>*/
/*       {% endif %}*/
/*     </header>*/
/*   {% endif %}*/
/* */
/*   <div{{ content_attributes.addClass('content') }}>*/
/*     {{ content|without('links') }}*/
/*   </div><!-- /.content -->*/
/* */
/*   {% if content.links %}*/
/*     <div class="links">*/
/*       {{ content.links }}*/
/*     </div><!-- /.links -->*/
/*   {% endif %}*/
/* */
/* </article><!-- /.node -->*/
/* */
