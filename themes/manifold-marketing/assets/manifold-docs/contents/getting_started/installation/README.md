# Installation

_Nota bene_: Manifold is very much a work in progress, and the installation story will likely change as we move toward a stable release. We'll update this document during development, in an effort to keep it fairly current, but expect things to be in flux for a while. In the future, we expect to provide Docker containers and OSX installers to make it easier to get up and running. We also plan on providing Ubuntu apt packages for easy Manifold installation.

### Basic Requirements

In order to run Manifold, you'll need the most recent stable version of Ruby, and the most recent LTS version of Node. We track the versions we target in the repository's [.ruby-version](https://github.com/ManifoldScholar/manifold/blob/development/api/.ruby-version) and [.node-version](https://github.com/ManifoldScholar/manifold/blob/development/client/.node-version) files. At the time of writing, we expect the host to be running Ruby 2.3.3 and Node 4.5.0. These installation documents do not cover installing Ruby or Node. That said, the Manifold development team generally uses [Rbenv](https://github.com/rbenv/rbenv) and [Nodenv](https://github.com/nodenv/nodenv) to manage Ruby and Node executables in our OSX development environments.

You will also need a functioning installation of Postgres 9.5. There are a few spots where we use BRIN indexes, which were introduced in version 9.5. We use Homebrew to manage our OSX Postgres installation. The Postgres website provides instructions on [installing Postgres on OSX](https://www.postgresql.org/download/macosx/). There are also a number of helpful resources online about running Postgres in a development environment, [such as this one.](https://www.codefellows.org/blog/three-battle-tested-ways-to-install-postgresql/)

Manifold search relies on ElasticSearch, which in turn relies on Java. On our development, staging, and production hosts, we are running ElasticSearch 5.1.x and Java 8. As with other dependencies, we've had good luck installing ElasticSearch with Homebrew on our development machines.

Finally, you'll want to have Redis installed for processing background jobs. Again, we've had good luck installing it with Homebrew: `brew install redis`

### Instructions

* [Setting up your Manifold Development Environment](/contents/developers/development_environment.md)




