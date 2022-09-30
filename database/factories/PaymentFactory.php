<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'merchant_id'=>$this->faker->creditCardNumber(),
            'merchantTid'=>$this->faker->randomNumber(8,true),
            'channel'=>'',
            'channel_ext'=>'',
            'merchant_order_id'=>'ICBCAIO'.$this->faker->creditCardNumber(),
            'merchant_user_id'=>substr('00000'.$this->faker->numberBetween(1,999999),6),
            'currency'=>'MOP',
            'amount'=>$this->faker->randomNumber(5),
            'timeout'=>900,
            'notify_url'=>'https://mgate.htubis.ltd',
            'return_url'=>'https://mgate.hubis.ltd',
            'sign'=>$this->faker->md5,
            'status'=>$this->faker->randomElement(['I','P','S','F']),
            'result'=>$this->faker->randomNumber(5),
        ];
    }
}
