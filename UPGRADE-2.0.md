# UPGRADE FROM 1.x to 2.0

## Services

 * The services for the `TwigRenderer` and the `DashboardExtension` are now configured by the bundles configuration.

   Before:

   ```yaml
   services:
       havvg_dashboard.renderer.twig:
           class: Havvg\Bundle\DashboardBundle\Dashboard\Renderer\TwigRenderer
           arguments:
               - '@twig'
           calls:
               -
                   - 'configure'
                   -
                       -
                           template: '::boardlets.html.twig'
                           default_block: 'boardlet_default'

       havvg_dashboard.twig.extension:
           class: Havvg\Bundle\DashboardBundle\Twig\DashboardExtension
           arguments:
               - '@havvg_dashboard.renderer.twig'
           tags:
               - { name: 'twig.extension' }
   ```

   After:

   ```yaml
   havvg_dashboard:
       twig:
           template: '::boardlets.html.twig'
           default_block: 'boardlet_default'
   ```

 * The `DashboardExtension` has been removed. The `TwigRenderer` now implements the `\Twig_ExtensionInterface`.
