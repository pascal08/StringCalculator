<?php

class StringCalculator
{

    /**
     * Ignores numbers equal or greater than this
     */
    const MAX_NUMBER_ALLOWED = 1000;

    /**
     * @var array
     */
    protected $numbers = [];

    /**
     * @var int
     */
    protected $sum = 0;

    /**
     * @var int
     */
    protected $product = 0;

    /**
     * @var array
     */
    protected $delimiters = [','];

    /**
     * @var bool
     */
    protected $negativeNumbersAllowed = false;

    /**
     * @param        $sNumbers
     * @return number
     * @internal param string $sDelimiters
     */
    public function sum($sNumbers)
    {
        $this->prepareIntegers($sNumbers);

        return $this->calculateSum();
    }

    /**
     * @param $sNumbers
     * @return $this
     * @throws Exception
     * @internal param $sDelimiters
     */
    protected function prepareIntegers($sNumbers)
    {
        $this->setNumbers($sNumbers);

        $this->extractNumbersFromString();

        $this->convertToIntegers();

        $this->filterIntegers();
    }

    /**
     * @param $sNumbers
     */
    protected function setNumbers($sNumbers)
    {
        if (!is_string($sNumbers)) {
            throw new \InvalidArgumentException();
        }

        $this->numbers = $sNumbers;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function extractNumbersFromString()
    {
        $pattern = '/[' . preg_quote(implode($this->delimiters), '/') . ']/';

        try {
            $this->numbers = preg_split($pattern, $this->numbers);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return $this
     */
    protected function convertToIntegers()
    {
        $this->numbers = array_map('intval', $this->numbers);
    }

    /**
     * @return $this
     */
    protected function filterIntegers()
    {
        $this->numbers = array_filter($this->numbers, function ($number) {
            if (!$this->negativeNumbersAllowed && $number < 0) {
                throw new \InvalidArgumentException('Invalid number provided: ' . $number);
            }

            return ($number < self::MAX_NUMBER_ALLOWED);
        });
    }

    /**
     * @return number
     */
    protected function calculateSum()
    {
        return $this->sum = array_sum($this->numbers);
    }

    /**
     * @return $this
     */
    public function allowNegativeNumbers()
    {
        $this->negativeNumbersAllowed = true;
    }

    /**
     * @param        $sNumbers
     * @return number
     * @internal param string $sDelimiters
     */
    public function product($sNumbers)
    {
        $this->prepareIntegers($sNumbers);

        return $this->calculateProduct();
    }

    /**
     * @return number
     */
    protected function calculateProduct()
    {
        return $this->product = array_product($this->numbers);
    }

    /**
     * @param $asDelimiters
     */
    public function setDelimiters($asDelimiters)
    {
        if (!is_array($asDelimiters) && !is_string($asDelimiters)) {
            throw new \InvalidArgumentException();
        }

        $this->delimiters = (array)$asDelimiters;
    }
}
