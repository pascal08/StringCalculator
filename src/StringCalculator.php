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
     * @var string
     */
    protected $delimiters = ',';

    /**
     * @param        $sNumbers
     * @param string $sDelimiters
     * @return number
     */
    public function sum($sNumbers, $sDelimiters = ',')
    {
        return $this
            ->prepareIntegers($sNumbers, $sDelimiters)
            ->calculateSum();
    }

    /**
     * @param        $sNumbers
     * @param string $sDelimiters
     * @return number
     */
    public function product($sNumbers, $sDelimiters = ',')
    {
        return $this
            ->prepareIntegers($sNumbers, $sDelimiters)
            ->calculateProduct();
    }

    /**
     * @param $sNumbers
     * @param $sDelimiters
     * @return $this
     * @throws Exception
     */
    protected function prepareIntegers($sNumbers, $sDelimiters)
    {
        $this->setNumbers($sNumbers);
        $this->setDelimiters($sDelimiters);

        return $t = $this
            ->extract()
            ->convertToIntegers()
            ->filterIntegers();
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
     * @param $sDelimiters
     */
    protected function setDelimiters($sDelimiters)
    {
        if (empty($sDelimiters)) {
            return;
        }

        if (!is_string($sDelimiters)) {
            throw new \InvalidArgumentException();
        }

        $this->delimiters = $sDelimiters;
    }

    /**
     * @return $this
     */
    protected function filterIntegers()
    {
        $this->numbers = array_filter($this->numbers, function ($number) {
            if ($number < 0) {
                throw new \InvalidArgumentException('Invalid number provided: ' . $number);
            }

            return ($number < self::MAX_NUMBER_ALLOWED);
        });

        return $this;
    }

    /**
     * @return $this
     */
    protected function convertToIntegers()
    {
        $this->numbers = array_map('intval', $this->numbers);

        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    protected function extract()
    {
        $pattern = '/[' . preg_quote($this->delimiters, '/') . ']/';

        try {
            $this->numbers = preg_split($pattern, $this->numbers);
        } catch (Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return $this;
    }

    /**
     * @return number
     */
    protected function calculateSum()
    {
        return $this->sum = array_sum($this->numbers);
    }

    /**
     * @return number
     */
    protected function calculateProduct()
    {
        return $this->product = array_product($this->numbers);
    }
}
