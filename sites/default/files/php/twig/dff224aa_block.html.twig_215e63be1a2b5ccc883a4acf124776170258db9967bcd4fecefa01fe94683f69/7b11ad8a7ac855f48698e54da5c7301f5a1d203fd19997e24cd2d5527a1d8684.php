<?php

/* block.html.twig */
class __TwigTemplate_28e2540020161b8b0e665364672f57f6b148ada85ee4a906d8f286296705f6f1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@block/block.html.twig", "block.html.twig", 1);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "@block/block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $tags = array("set" => 29);
        $filters = array("clean_class" => 30);
        $functions = array();

        try {
            $this->env->getExtension('sandbox')->checkSecurity(
                array('set'),
                array('clean_class'),
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

        // line 29
        $context["attributes"] = $this->getAttribute((isset($context["attributes"]) ? $context["attributes"] : null), "addClass", array(0 => array(0 => ("block-" . \Drupal\Component\Utility\Html::getClass($this->getAttribute(        // line 30
(isset($context["configuration"]) ? $context["configuration"] : null), "provider", array()))), 1 => $this->getAttribute(        // line 31
(isset($context["attributes"]) ? $context["attributes"] : null), "id", array()))), "method");
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 1,  50 => 31,  49 => 30,  48 => 29,  11 => 1,);
    }
}
/* {% extends "@block/block.html.twig" %}*/
/* {#*/
/* /***/
/*  * @file*/
/*  * Theme override to display a block.*/
/*  **/
/*  * Available variables:*/
/*  * - plugin_id: The ID of the block implementation.*/
/*  * - label: The configured label of the block if visible.*/
/*  * - configuration: A list of the block's configuration values.*/
/*  *   - label: The configured label for the block.*/
/*  *   - label_display: The display settings for the label.*/
/*  *   - provider: The module or other provider that provided this block plugin.*/
/*  *   - Block plugin specific settings will also be stored here.*/
/*  * - content: The content of this block.*/
/*  * - attributes: array of HTML attributes populated by modules, intended to*/
/*  *   be added to the main container tag of this template.*/
/*  *   - id: A valid HTML ID and guaranteed unique.*/
/*  * - title_attributes: Same as attributes, except applied to the main title*/
/*  *   tag that appears in the template.*/
/*  * - title_prefix: Additional output populated by modules, intended to be*/
/*  *   displayed in front of the main title tag that appears in the template.*/
/*  * - title_suffix: Additional output populated by modules, intended to be*/
/*  *   displayed after the main title tag that appears in the template.*/
/*  **/
/*  * @see template_preprocess_block()*/
/*  *//* */
/* #}*/
/* {% set attributes = attributes.addClass([*/
/*   'block-' ~ configuration.provider|clean_class,*/
/*   attributes.id*/
/* ]) %}*/
/* */
