<?php namespace Castiron\Manifold\Components;

use Cms\Classes\ComponentBase;

class Seed extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'seed Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function posts()
    {
        $post1 = array(
          'title' => 'Manifold v0.2.0 Released',
          'summary' => 'On behalf of the entire Manifold team, I’m super excited to announce the release of Manifold v0.2.0! The release is up on Github now, and we’ll be rolling it out to our staging site later today. This release contains a number of new features and bugfixes, listed below. For the full list of revisions and pull requests, please consult the changelog.',
          'link' => '#'
        );

        $post2 = array(
          'title' => 'Manifold v0.1.3 released to staging.manifoldapp.org',
          'summary' => 'On behalf of the entire Manifold team, I’m super excited to announce the release of Manifold v0.2.0! The release is up on Github now, and we’ll be rolling it out to our staging site later today. This release contains a number of new features and bugfixes, listed below. For the full list of revisions and pull requests, please consult the changelog.',
          'link' => '#'
        );

        $post3 = array(
          'title' => 'Manifold v0.1.1 Released',
          'summary' => 'Version 0.1.1 of Manifold is a bugfix release. It has been pushed to the Manifold staging instance. This release includes the following fixes and improvements.',
          'link' => '#'
        );

        return array($post1, $post2, $post3);
    }

    public function newspaper()
    {
        return "
    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p>
    <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
    <p>Et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia.</p>
    <p>Et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.</p>
    <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.</p>
    <p>Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>
";
    }

    public function partners()
    {
      $partner1 = array(
          'name' => 'University of Minnesota Press',
          'logo_path' => 'themes/manifold-marketing/assets/images/logo-mn.png',
          'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.',
          'link' => '#'
      );

      $partner2 = array(
        'name' => 'Cast Iron Coding',
        'logo_path' => 'themes/manifold-marketing/assets/images/logo-cic.svg',
        'description' => 'issimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.',
        'link' => '#'
      );

      $partner3 = array(
        'name' => 'GC Digital Scholarship Lab at the Graduate Center, CUNY',
        'logo_path' => 'themes/manifold-marketing/assets/images/logo-cic.svg',
        'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.',
        'link' => '#'
      );

      return array($partner1, $partner2, $partner3);
    }
}
