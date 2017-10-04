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
          'description' => 'The University of Minnesota Press is recognized internationally for its innovative, boundary-breaking editorial program in the humanities and social sciences and as publisher of the Minnesota Multiphasic Personality Inventory (MMPI), the most widely used objective tests of personality in the world. Minnesota also maintains as part of its mission a strong commitment to publishing books on the people, history, and natural environment of Minnesota and the Upper Midwest. Established in 1925, Minnesota is among the founding members of the Association of American University Presses (AAUP).',
          'link' => 'https://www.upress.umn.edu/'
      );

      $partner2 = array(
        'name' => 'Cast Iron Coding',
        'logo_path' => 'themes/manifold-marketing/assets/images/logo-cic.svg',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sit amet ipsum at arcu tempus dictum ut aliquet sapien. Etiam risus est, suscipit in consectetur eget, euismod non nunc. Sed ut erat et erat scelerisque rutrum eget vitae diam. Sed mollis nulla et elit dapibus, a convallis felis fermentum.',
        'link' => 'http://castironcoding.com/'
      );

      $partner3 = array(
        'name' => 'GC Digital Scholarship Lab at the Graduate Center, CUNY',
        'logo_path' => 'themes/manifold-marketing/assets/images/logo-cuny.svg',
        'description' => 'The GC Digital Scholarship Lab is a research and community space at the Graduate Center of the City University of New York that focuses on the creation and use of collaboratively produced, community-based open-source software platforms for scholarly communication.',
        'link' => 'https://gcdsl.commons.gc.cuny.edu/'
      );

      return array($partner1, $partner2, $partner3);
    }

    public function services()
    {
      $production_services = array(
        'background' => 'gray',
        'title' => 'Production Services',
        'packages' => array(
          array(
            'price' => '$3,000',
            'name' => 'Base Package',
            'content' => "
              <div class='copy-secondary'>Includes the following services for one project file and up to ten resources:</div>
              <div class='flex-row'>
                <div class='col'>
                  <div class='subheading-secondary'>book file</div>
                  <ul>
                    <li>Cleanup of file structure</li>
                    <li>Ingestion onto system</li>
                    <li>Basic metadata curation</li>
                  </ul>
                </div>
                <div class='col'>
                  <div class='subheading-secondary'>resources</div>
                  <ul>
                    <li>Ingestion onto system</li>
                    <li>Placement within text(s)</li>
                    <li>Basic metadata curation</li>
                  </ul>
                </div>
              </div>
            "
          ),
          array(
            'price' => '$1,000',
            'name' => 'Resource Package',
            'content' => "
              <div class='copy-secondary'>Add a block of ten resources (at once or over time) to existing projects, with the following services:</div>
              <ul>
                <li>Ingestion onto system</li>
                <li>Placement within text(s)</li>
                <li>Metadata curation</li>
              </ul>
            "
          ),
          array(
            'price' => 'Variable',
            'name' => 'Accessibility Package',
            'content' => "
              <div class='copy-secondary'>For those who would like customized accessibility metadata crafted for their resources, we offer that service at the above rate for groups of ten resources.</div>
            "
          ),
          array(
            'price' => 'Variable',
            'name' => 'Copyediting Package',
            'content' => "
              <div class='copy-secondary'>Call to discuss and get a quote for which of the following services are right for your project:</div>
              <ul>
                <li>Cleanup of file structure</li>
                <li>Text tagging and encoding</li>
                <li>
                  Copyediting:
                  <ul>
                    <li>Evaluating level of edit needed</li>
                    <li>Preparing bespoke editing instructions for the copy editor</li>
                    <li>Scheduling and coordinating workflow with freelance copy editor and author(s)</li>
                    <li>Reviewing and finalizing edit</li>
                  </ul>
                </li>
              </ul>
              <div class='copy-secondary'>Files will be reviewed upon submission to confirm their level of complexity falls within the expected range. You will be notified if your materials may require extra time or attention before we commence our work.</div>
            "
          )
        )
      );

      $hosting_services = array(
        'background' => 'white',
        'title' => 'Hosting Services',
        'packages' => array(
          array(
            'price' => '$???',
            'name' => 'Consultation Package',
            'content' => "
              <div class='copy-secondary'>For organizations wanting hosting assistance and consultation, we will work with you to examine the best hosting options available for your situation—be they your own servers or cloud‐based solutions.</div>
            "
          ),
          array(
            'price' => '$???',
            'name' => 'Installation Package',
            'content' => "
              <div class='copy-secondary'>A one‐time service, deploying and configuring the platform to your or a service‐provider's servers.</div>
            "
          ),
          array(
            'price' => 'Variable',
            'name' => 'Maintenance Package',
            'content' => "
              <div class='copy-secondary'>To keep pace with new features and enhancements we offer platform upgrades and maintence at a rate of $$$/hour.</div>
            "
          )
        )
      );

      $customization_services = array(
        'background' => 'gray',
        'title' => 'Customization Services',
        'packages' => array(
          array(
            'price' => 'Variable',
            'name' => 'Feature Package',
            'content' => "
              <div class='copy-secondary'>For organizations that want to create custom add‐ons to the platform, we will work with you to design, test, and implement those features at a rate of $$$/hour.</div>
            "
          )
        )
      );

      return [$production_services, $hosting_services, $customization_services];
    }

    public function faqs()
    {
      return [
        array(
          'question' => 'What files are supported for upload into Manifold?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'What if I don’t have an epub? Can I still upload a text to Manifold?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'Can I turn off the commenting feature?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        ),
        array(
          'question' => 'How can I customize the Project landing page?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'Can I customize the branding in my installation of Manifold?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'What types of media are supported to upload into the Resource section?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'What is the size limit for media uploaded into the Resource section?',
          'answer' => 'Lorem ipsum dolor sit amet.'
        ),
        array(
          'question' => 'What if I don’t have permission to upload media to the Resource section?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus.'
        ),
        array(
          'question' => 'Do I need an internet connection to use Manifold?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        ),
        array(
          'question' => 'What is the minimum metadata requirement for starting a project?',
          'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc egestas, purus sit amet tincidunt ultrices, lectus justo sagittis tortor, pharetra euismod orci velit ut metus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        )
      ];
    }

    public function testimonials()
    {
      return [
        array(
          'quotation' => 'The process of writing a book introduces you to archivists and artists, friends and colleagues. Once published, all of those collaborations are fixed in a static artifact. The promise of Manifold is not only that new communities can continue to form around a book, but also that the book in turn can continue to evolve around its interlocutors.',
          'author' => 'Grant Wythoff',
          'source' => 'editor of <em>The Perversity of Things: Hugo Gernsback on Media, Tinkering, and Scientifiction</em>'
        ),
        array(
          'quotation' => 'Donec tristique, turpis non viverra auctor, leo justo sagittis lectus, eu molestie orci nunc in dui. Sed tristique aliquam dui non accumsan. Praesent blandit id massa sit amet varius. Phasellus commodo nec lorem at consequat. Cras sit amet nulla nec est elementum pulvinar. Vestibulum in sem egestas, finibus nibh nec, rutrum nibh. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.',
          'author' => 'Quisque arcu risus',
          'source' => 'editor of <em>Donec aliquam, elit et ultricies volutpat, erat nisi iaculis neque</em>'
        ),
        array(
          'quotation' => 'Quisque arcu risus, condimentum at ligula vitae, condimentum facilisis lacus. Etiam lectus turpis, scelerisque non malesuada sit amet, egestas blandit nibh. Morbi sollicitudin odio eu consectetur bibendum. Phasellus pulvinar sodales nisi a vulputate.',
          'author' => 'Duis pretium',
          'source' => 'editor of <em>Duis quis nunc id enim tempus vehicula</em>'
        ),
        array(
          'quotation' => 'Suspendisse semper in diam eu lacinia. Sed lacus elit, pharetra vel sagittis eget, laoreet ut quam. Donec tristique, turpis non viverra auctor, leo justo sagittis lectus, eu molestie orci nunc in dui. Sed tristique aliquam dui non accumsan. Praesent blandit id massa sit amet varius. Phasellus commodo nec lorem at consequat.',
          'author' => 'Nulla dictum',
          'source' => 'editor of <em>Integer sed dui at nisi dignissim sagittis ut ut lectus</em>'
        )
      ];
    }

    public function links()
    {
      return [
        array(
          "text" => "Publishers",
          "url" => "#",
          "icon" => "bookpile-small"
        ),
        array(
          "text" => "Developers",
          "url" => "#",
          "icon" => "laptop-dev"
        ),
        array(
          "text" => "Readers",
          "url" => "#",
          "icon" => "book-page-turn"
        ),
        array(
          "text" => "Authors",
          "url" => "#",
          "icon" => "laptop"
        ),
      ];
    }

    public function supporters()
    {
      return [
        array(
          'text' => 'GitHub',
          'link' => '#',
          'icon' => 'github-logo'
        ),
        array(
          'text' => 'Documentation',
          'link' => '#',
          'icon' => 'manifold-doc'
        ),
        array(
          'text' => 'Gitter',
          'link' => '#',
          'icon' => 'gitter-logo'
        ),
        array(
          'text' => 'Services',
          'link' => '#',
          'icon' => 'hand'
        )
      ];
    }
}
