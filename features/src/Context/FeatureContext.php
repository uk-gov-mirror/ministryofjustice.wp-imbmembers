<?php

namespace ImbMembers\Features\Context;

use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawWordpressContext implements SnippetAcceptingContext
{

    /**
     * Initialise context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Reset the browser session and nagivate to the homepage after each scenario.
     *
     * Navigating to the homepage means the body element will no longer have a '.logged-in' class,
     * which is used by \PaulGibbs\WordpressBehatExtension\Context\Traits\UserAwareContextTrait to
     * determine if a user is logged in.
     *
     * @AfterScenario
     *
     * @When I reset my session
     */
    public function resetSessionAndGoToHomepage()
    {
        $this->getSession()->reset();
        $this->visitPath('/');
    }
}
