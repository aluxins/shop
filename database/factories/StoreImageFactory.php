<?php

namespace Database\Factories;

use App\Models\StoreImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StoreImage>
 */
class StoreImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product' => rand(1,10),
            'name' => '',
            'sort' => rand(1,20),
        ];
    }

    /**
     * @return array[]
     */
    public static function DataImages(): array
    {
        return [
            ['FhendMad92vuNy4axSr6Ode0HrLVWJwvikQWzEXP.jpg','WQrklQ4m4BWv0eSmHZGnpnOBwffCjv6klMi80drL.jpg','0KkVJKGEk1X0bTVvQ9GIFGy1Sm6GzEmSebAdsiit.jpg','1pXz9UnNmmtpdJFaeu6Ha1RDLOVJW5wDrc2fIBiR.jpg',],
            ['Yji8J8yywUts7JE9ym3yqAJ4ddzGHqW9dyQeK0VC.jpg','3FwyRqWb0lywVsAiDG9EnyBOccoqkkbddYR1mY4w.jpg','A7A6bS1uensohDn5RSQKatCjCfzfqq4KCvV9l5MQ.jpg','B7Rz2wEq03Qs9wNba07CjSkav62F3dJJFsARPW9r.jpg',],
            ['M4aLbJbf9yXciB9EQIlhEs12V61AVj3gATSeGU87.jpg','R9l3CpC2XjOwWcMzqJotRFalHoocH6IxrlgU9P1n.jpg','7RpH3mIT6dVinCSEnYqxGeEcei0XYYiSauipF4Ho.jpg','R4wDDUG41uv0MTpHph5yuxB7fxDSkCFtAUFh1x3F.jpg',],
            ['6a87Osa5eBQAtfo76YTzfHikDMoiIZxQFNNRQ1uM.jpg','0mFk6HNDtrMg85uMCQFvaOEYqtvujQSr2mkILDyE.jpg','Di2K6hWAL1LmPoj0NXVhVVaJGObvCdzCJRrgXuc3.jpg','YMPIJFwDchq2xis3AMWanW4PqKA5fnL8XL7iHtij.jpg',],
            ['RWmmltu486QJufZJskmENyURa99cNhJHtb9TAnEi.jpg','9eOXHKMKCJvaCw0baFPGo0GzspRCikT5D9XywJmM.jpg','HBVwW6RZi59ZCf6IiUdW9CodQZO0i8Mqd6g7DrUP.jpg','J5FicBO0rFNp5kDfZEoJCR2SUiYaYCSklLpizbXi.jpg',],
            ['0Ygmb8IRKnLqM4w5CyTVbDc80J1aKKzGbL9UPQJt.jpg','JWTWgxR4M02k0SxCfyAna4dq1X6PLPzWKNUCKkLK.jpg',],
            ['pkNc0G5LMmmnRuCkJ0AC8NUMjIyHCw1dhNjMNx22.jpg','tAyhIrZJLivrnmtrJJPjfvYF4Z4fTz5nNSCsojcy.jpg',],
            ['IAMNiPS4POOjGTzYsqPJ7DpkJrxeVUGDxRrj8m5H.jpg','te111hznvJykAMTany0Mf6yFZ6ftJgxdIKoyc7Jr.jpg','41T6b1CIAYaHJtqL07lFy4fycUGy8k7rF9B57vOf.jpg','yo8nhm1xf1uM1iHhPf5D6WiaBduHfgpgiJFBBhmh.jpg',],
            ['uukVajeZQfkiZjjjJcQ2NPLBO4pxfX4eFW9GZ96K.jpg','NXFk1M8AOYiUYPJd1hFEQlGUeWx2SBehjpP7ws6N.jpg','aFPSR7O7as5U7h0jRiHbwgHW9y0VZSQVa5vJuxRD.jpg','Xp888nCX00l1ZUWecbWLipU7LhXHqpzBsbSZYtVT.jpg',],
            ['SJcKRFOZSBwqSE95mZYrthpyhY50OX6VX4s9FjLY.jpg','mj18BvWNp8sTEG8L9yAfuzj1HDhnDHz6PCHrdrdT.jpg',],
            ['AKDxNB2e2gvvVQnYSBheaVzNQTXAj6YIY9wwLD1B.jpg','xu0EtmdwwkNPEZ5qsr7DKe9gjRjF6GRnALAaZnx8.jpg','dmCZ4Y4ruiqQtxHP2kXKDpvwo9C6W00GHWWYGlEc.jpg','NFocmoz3rqSSRyCmmBE8Cyd1n6M0zYL45ha39nb7.jpg',],
            ['0kWwbX1qnNVFndUHZfMDX5FdYwIUP50jYUPIEW3W.jpg','g3XcBQHQwYQ4WNM4F7b5GN8pqT131pch83qd7mrc.jpg','v4ZDNEohu1jQEJ7ZI6tcCxKIofydbrHmF8V6yhDY.jpg','rUCFpB3u05bWEnp1gDelU4BMLIOiH57HHX0ixWLv.jpg',],
            ['bdazYcrYNVL8IssA1bhkULIDwIpCYdDHL0BxUf6h.jpg','TYQOhA23560exGiVxi5lOTJjfziRcP9IK1eYdFnz.jpg','QpfvL2oyFkkdn4QYcWDZhvabbIlQKiwtqp6M5ao1.jpg','ZRd81HxBbCwkKVUZXMIbuCUhNTSbTJHB4yAMTErB.jpg',],
            ['5wjwFlMQqHMM5pUXm33zEBmPWmI0IdQHiJuCvNsE.jpg','EsqfueN5qhh8tSpV8VbPAMCLOXd81JIw30qWhnox.jpg','1KIuOSSlBDGPqrLCNVVR2E1z478R0dFCMDCqcFpd.jpg','4ggADUacAgdwM0JAjqHacYKLt6aDuOKuDxv0GOAS.jpg',],
            ['UJ5cHgJgx7HodkzJOJismJK2E0mETu5It1eF6Aba.jpg','GWYupqtQHieipZ6P9ZOWnodVEGJ8DRLvYfkv46HJ.jpg','PIv6KgPbPquc1TnORA5u4FXCg6ahlT28RVRdS6z2.jpg','gA6B42ToYbCK2GBdJE01ekOjiFzGvlc1f3x2SOas.jpg',],
            ['EY6VcNfWrqAC7lSauq5VbQt3oi5tEQfmj6fu8F0K.jpg','nFlV7Ispxq4zbPvaDxku3Vyd821AdAMJ7cDm7kSb.jpg','r4q9FozhDkihayDkyVbWnrMoa0NIyxPBRbAhbN84.jpg','BJa0fEOh3qZO8MBjdfTToIyQ5kEtflaJmqbmFh2N.jpg',],
            ['0mLxmG8lOqksgwL0oDNS2kIFaS6UL4xO1IJNhLvP.jpg','y1BvpzbhgNM2tqnjqgJ8yhEP4BAiezfZgl1SiFuU.jpg','QNmmKyEmx8GKOsCaowm53oGoob2VccMjeD7pSL5E.jpg','aF1NafOZjClp2Re8TWfqoDvOd3h9Fy32gpi7Ifgg.jpg',],
            ['8CSalinfqSSJZspwJwXgL48B9bqMbm2WeZMpcx7h.jpg','bbDEuTuIW8ORfBmQQzrKo8BX8XQ5fiDsBYZiByp7.jpg','XR3OGRZOtN8j01XXyaHRNIXm1oXTORbIHvzUeZaa.jpg','aBufjQ2BL47CeTyJ4ti1X1vshfzqsYVXaeZG69Xo.jpg',],
            ['srnsaLZ8NUgT1lgPKlDTztTmL5FCJfw2IFTBreAG.jpg','CXsaqJB2Rmcjhxz94dO3ppPQuHSQ4DGUlUsgoAEH.jpg','5HixEBwrHNgAUnwLvTlwRIhaXoRRKIa9XSYItDJU.jpg','dMOjIlTJxKg0YcYS2Kd1j6IMH34p9tPMmzSRi86z.jpg',],
            ['WEIffMwGfE36Xily3Hgzisvv1mn57dbRAxVKFNGc.jpg','xAFMAqKS4vR0FfHkZ0WCCmFPBIVRhfVZySmOGVmd.jpg','wt2A5C41T69VpEcJRIPtlqEfWM0ZAkHtJb0TY1P0.jpg','iTd7IAu2h9QdkHLy3L3qNqIpa38bx67cAiVMzWNU.jpg',]
        ];
    }
}
