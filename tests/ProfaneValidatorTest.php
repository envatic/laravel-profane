<?php

namespace LaravelProfaneTests;

use LaravelProfane\ProfaneValidator;
use LaravelProfaneTests\TestCase;
use LaravelProfaneTests\Support\ProfaneValidatorBuilder;

class ProfaneValidatorTest extends TestCase
{
    public function test_can_set_dictionary_when_you_pass_a_locale()
    {
        $builder = new ProfaneValidatorBuilder('es');

        $expected = include __DIR__.'/../src/dict/es.php';

        $this->assertEquals($builder->build()->getBadwords(), $expected);
    }

    public function test_can_set_dictionary_when_you_pass_a_file()
    {
        $builder = new ProfaneValidatorBuilder(__DIR__.'/../src/dict/es.php');

        $expected = include __DIR__.'/../src/dict/es.php';

        $this->assertEquals($builder->build()->getBadwords(), $expected);
    }

    public function test_can_set_dictionary_when_you_pass_an_array_of_files()
    {
        $builder = new ProfaneValidatorBuilder([
            __DIR__.'/../src/dict/es.php',
            __DIR__.'/../src/dict/en.php'
        ]);

        $expected = array_merge(
            include __DIR__.'/../src/dict/es.php',
            include __DIR__.'/../src/dict/en.php'
        );

        $this->assertEquals($builder->build()->getBadwords(), $expected);
    }

    public function test_can_set_dictionary_when_you_pass_an_array_of_locales()
    {
        $builder = new ProfaneValidatorBuilder(['es', 'en', 'it', 'zh-tw']);

        $expected = array_merge(
            include __DIR__.'/../src/dict/es.php',
            include __DIR__.'/../src/dict/en.php',
            include __DIR__.'/../src/dict/it.php',
            include __DIR__.'/../src/dict/zh-tw.php'
        );

        $this->assertEquals($builder->build()->getBadwords(), $expected);
    }

    public function test_can_validate_a_word_with_numbers()
    {
        $builder = new ProfaneValidatorBuilder();

        $this->assertFalse($builder->validate(['username', 'culero23', ['es']]));
    }

    public function test_can_validate_a_text()
    {
        $builder = new ProfaneValidatorBuilder();

        $this->assertFalse($builder->validate(['description', 'fck you bitch. 幹!', ['es', 'en' , 'zh-tw']]));
    }

    public function test_can_evaluate_profanity_of_a_word()
    {
        $builder = new ProfaneValidatorBuilder();

        $word = 'fuck';

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_can_evaluate_profanity_of_a_sentence()
    {
        $builder = new ProfaneValidatorBuilder();

        $word = 'fuck you if you read this';

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_can_evaluate_profanity_of_a_html_string()
    {
        $builder = new ProfaneValidatorBuilder();

        $word = '<b>fuck</b> you if you read this.';

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_can_evaluate_as_caseless_mode()
    {
        $builder = new ProfaneValidatorBuilder();

        $word = '<b>FUCK</b> you BITCH if you read this.';

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_match_exact_word()
    {
        $builder = new ProfaneValidatorBuilder();

        // it thinks class ~= ass
        $this->assertTrue($builder->build()->isProfane('class'));

        // but this should be profane
        $this->assertTrue($builder->build()->isProfane('sucker96'));
    }

    public function test_can_validate_a_bad_word_with_accent()
    {
        $builder = new ProfaneValidatorBuilder('sk');

        $word = "piča";

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_enie_in_spanish_is_evaluated()
    {
        $builder = new ProfaneValidatorBuilder('es');

        // in spanish coño =! cono
        $word = "coño";

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_can_validate_a_word_in_greek()
    {
        $this->mockConfigs();

        $builder = new ProfaneValidatorBuilder('gr');

        $word = "μαλάκας";

        $this->assertTrue($builder->build()->isProfane($word));
    }

    public function test_can_validate_a_text_in_greek()
    {
        $this->mockConfigs();

        $builder = new ProfaneValidatorBuilder();

        $this->assertFalse($builder->validate(['description', 'εισαι πουτανα', ['en' , 'gr']]));
    }
}
