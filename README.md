# covid_test_group_prove

Vừa rồi trên Tivi có giới thiệu là phương pháp xét nghiệm Covid theo nhóm để đẩy nhanh tốc độ xét nghiệm. Nói nôm na tức là thay vì chỉ xét nghiệm 1 người thì sẽ tiến hành xét nghiệm n người. 
Ví dụ nếu chia tất cả các mẫu xét nghiệm thành nhóm 5 người thì sẽ trộn mẫu của 5 người này lại và xét nghiệm, nếu âm tính tức là tất cả đều âm tính. Nếu dương tính thì sẽ phải xét nghiệm tiếp trong nhóm 5 người này.

Cho biết xác xuất nhiễm COVID xét nghiệm trước đó của nước đó là x (x<=1). 
Số người tối đa trong 1 nhóm để việc xét nghiệm nhóm còn có hiệu quả là N. 
Số người cần xét nghiệm thời điểm đó là P.
Tìm nghiệm tối ưu của n (số người trong 1 nhóm) để số lần xét nghiệm là thấp nhất (tính theo xác suất).

Tiện đang rảnh với lại cũng tò mò nên thử giải bài toán này xem sao.
Lưu ý: Kiến thức xác suất, lập trình của mình có thể bị thiếu sót nên bài viết chỉ mang tính tham khảo.

Ví dụ theo cách xét nghiệm truyền thống thì với P người thì ta sẽ phải xét nghiệm P lần.

Còn nếu theo các xét nghiệm nhóm thì ta sẽ chia P người vào nhóm, mỗi nhóm có n người. Vậy là ta sẽ có trung bình P/n nhóm (chính xác hơn là nếu P không chia hết cho n thì sẽ phải có P/n +1 nhóm, tuy nhiên để dễ tính toán thì ta sẽ làm tròn về P/n nhóm).

Lúc đó khi trộn các mẫu xét nghiệm trong cùng 1 nhóm với nhau và đi xét nghiệm thì ta sẽ có P/n nhóm nên ở lần 1 ta sẽ phải xét nghiệm P/n lần.

Lúc này ta sẽ phải tính xác suất xem là trong P/n nhóm này sẽ có bao nhiêu nhóm dương tính với Covid để tiếp tục làm xét nghiệm bước 2.

Với nhóm n người đánh dấu là A1, A2, ..., An.
Khi chọn người đầu tiên là A1 thì xác suất dương tính với Covid của người này là x, => xác suất âm tính (tức là không dương tính) Covid của người này là P(A1) = (1-x)
Khi chọn người thứ 2 là A2 thì ta sẽ có xác suất để cả 2 người âm tính với Covid sẽ là: P(A1A2) = P(A1)*P(A2/A1) trong đó P(A2/A1) là xác suất để người thứ 2 âm tính Covid khi xảy ra P(A1). Lúc này số người dương tính với Covid vẫn là xP, trong khi số người còn lại là P-1 nên xác suất dương tính với Covid sẽ là xP/(P-1) => Xác suất âm tính với Covid của người thứ 2 là P(A2/A1)= (1-xP/(P-1))
=> Xác suất để cả 2 người âm tính với Covid sẽ là: P(A1A2) = (1-x) * (1-xP/(P-1))
Tính tương tự thì ta sẽ có xác suất để nhóm n người âm tính với Covid sẽ là:
P(A1A2...An) = (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1))

=> xác suất để nhóm n người này dương tính với Covid sẽ là P(n) = 1 - P(A1A2...An)
= 1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1))
=> Số lần xét nghiệm trung bình lần 2 của mỗi nhóm sẽ là: n * P(n) = n * (1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1)))
=> Số lần xét nghiệm trung bình lần 2 của P/n nhóm sẽ là: P/n * n * P(n) = P*P(n)

=> Tổng số lần xét nghiệm ở cả 2 lần theo phướng pháp nhóm sẽ là: f(n) = P/n + P*P(n) = P (1/n + P(n) = P* (1/n + 1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1)) )
Lúc này yêu cầu của chúng ta sẽ là tìm nghiệm n sao cho hàm trên có giá trị nhỏ nhất.
Ta có là 1 hàm đạt giá trị cực tiểu khi mà đạo hàm tại đó bằng 0, do đó ta phải tìm giá trị n sao cho f’(n)=0 với P và x là các hằng số.

Nhìn vào cái hàm hơi phức tạp là thấy hơi đau não rồi, nên giải quyết theo bài toán tổng quát có vẻ sẽ khá tốn thời gian và phức tạp nên tới đây mình chợt nghĩ ra việc tận dụng lập trình vào việc giải quyết bài toán. 
Ta sẽ cho đầu vào là các tham số P(số người xét nghiệm), x( xác suất dương tính trước đó) và N( số người tối đa trong 1 nhóm để việc xét nghiệm theo nhóm vẫn cho kết quả chính xác). Và ta sẽ tìm nghiệm n sao cho f(n) có giá trị nhỏ nhất.
Cách đơn giản nhất là ta sẽ chạy vòng lặp từ 1 tới N và tìm ra giá trị f(n) rồi sau đó tính toán giá trị n ở đó f(n) nhỏ nhất.

Do hiện tại công ty mình dùng PHP nên mình sẽ dùng code PHP để mô phỏng bài toán.
Đầu tiên ta sẽ tạo hàm để trả về số lần xét nghiệm của phương pháp truyền thống hiện tại.

```php
function traditionalTestTime(int $numberOfTestPerson): int {
    return $numberOfTestPerson;
}
```

Tiếp theo ta sẽ tạo hàm để trả về số nhóm nếu mình chia P người theo n nhóm.
```php
function numberOfGroup(int $numberOfTestPerson, int $numberOfPeopleInGroup): int {
    return (int) round($numberOfTestPerson/$numberOfPeopleInGroup);
}
```



Tiếp theo ta sẽ tạo 1 hàm để trả về số lần xét nghiệm trong lần 1. Hàm này chỉ đơn giản trả về số nhóm
```php
function newTestTotalTestTimeStep1(int $numberOfTestPerson, int $numberOfPeopleInGroup): int {
    return numberOfGroup($numberOfTestPerson, $numberOfPeopleInGroup);
}
```

Tiếp theo ta sẽ tạo 1 hàm để tính xác suất dương tính với Covid của nhóm n người. Ở trên ta có công thức

P(n) = 1 - P(A1A2...An)
= 1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1))

Nên ta sẽ có hàm tương ứng dưới đây.

```php
function positiveTestProbabilityOfGroup(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): float {
    // P(n) = 1 - P(A1A2...An) = 1 - (1-x) * (1-xP/(P-1)) * (1-xP/(P-2)) * ... * (1-xP/(P-n+1))
    $negativeTestProbability = 1.0; // P(A1A2...An)
    for ($i=1; $i<=$numberOfPeopleInGroup; $i++) {
        $negativeTestProbability = $negativeTestProbability * (1 - $avgPositiveTestRate*$numberOfTestPerson/($numberOfTestPerson - $i +1));
    }
    return 1 - $negativeTestProbability;
}
```

Từ hàm trên ta sẽ tính được tổng số lần phải xét nghiệm trong lần thứ 2 theo công thức:
g(n) = P/n * n * P(n) = P*P(n)

```php
function newTestTotalTestTimeStep2(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): int {
    // g(n) = P/n * n * P(n) = P*P(n)
    return (int) $numberOfTestPerson * positiveTestProbabilityOfGroup($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate);
}
```

Cuối cùng ta sẽ có được hàm tính tổng số lần xét nghiệm của phương pháp mới như sau:

```php
function newTestTotalTestTime(int $numberOfTestPerson, int $numberOfPeopleInGroup, float $avgPositiveTestRate): int {
    return newTestTotalTestTimeStep1($numberOfTestPerson, $numberOfPeopleInGroup) + newTestTotalTestTimeStep2($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate);
}
```

Sau khi có tất cả các hàm trên, ta sẽ tạo một hàm chính để in ra kết quả số lần xét nghiệm với n chạy từ 2 tới N như sau:

```php
function main(int $numberOfTestPerson, float $avgPositiveTestRate, int $maxEffectiveNumberInGroup) {
    $traditionalTestTime = traditionalTestTime($numberOfTestPerson);
    printf("Traditional Test time: %d\n\n", $traditionalTestTime);
    $minNewTestTime = $traditionalTestTime;
    $bestNumberOfPeopleInGroup = -1;
    for ($numberOfPeopleInGroup=2; $numberOfPeopleInGroup<=$maxEffectiveNumberInGroup; $numberOfPeopleInGroup++) {
        $totalTestTime = newTestTotalTestTime($numberOfTestPerson, $numberOfPeopleInGroup, $avgPositiveTestRate);
        printf("New Test time with n=%d: %d\n", $numberOfPeopleInGroup, $totalTestTime);
        if ($minNewTestTime > $totalTestTime) {
            $minNewTestTime = $totalTestTime;
            $bestNumberOfPeopleInGroup = $numberOfPeopleInGroup;
        }
    }

    if ($minNewTestTime < $traditionalTestTime) {
        printf("\nNew Test Method is better with %d people in 1 group. 
For traditional method, we need %d times, but for new method we only need %d times, %.2f percentage of traditional one.\n",
            $bestNumberOfPeopleInGroup, $traditionalTestTime, $minNewTestTime, $minNewTestTime*100/$traditionalTestTime);
    } else {
        printf("Traditional method is still better!\n");
    }
}
```


Giả dụ hiện tại Hà Nội đang có 72,275 người cần trở về từ Đà Nẵng cần xét nghiệm, tỉ lệ dương tính Covid trước giờ của Việt Nam là 797 người mắc/482456 tổng số xét nghiệm.
Giả dụ phương pháp nhóm có thể hoạt động hiệu quả với tối đa 50 người thì ta sẽ có kết quả như sau :

```php
$numberOfTestPerson = 72275;
$avgPositiveTestRate = 797/482456;
$maxEffectiveNumberInGroup = 50;
main($numberOfTestPerson, $avgPositiveTestRate, $maxEffectiveNumberInGroup);
```

php.exe covid_group_test.php
Traditional Test time: 72275

New Test time with n=2: 36376

New Test time with n=3: 24449

New Test time with n=4: 18545

New Test time with n=5: 15050

New Test time with n=6: 12759

New Test time with n=7: 11156

New Test time with n=8: 9983

New Test time with n=9: 9098

New Test time with n=10: 8413

New Test time with n=11: 7872

New Test time with n=12: 7442

New Test time with n=13: 7096

New Test time with n=14: 6816

New Test time with n=15: 6588

New Test time with n=16: 6404

New Test time with n=17: 6254

New Test time with n=18: 6134

New Test time with n=19: 6039

New Test time with n=20: 5965

New Test time with n=21: 5908

New Test time with n=22: 5867

New Test time with n=23: 5839

New Test time with n=24: 5823

New Test time with n=25: 5817

New Test time with n=26: 5821

New Test time with n=27: 5832

New Test time with n=28: 5851

New Test time with n=29: 5876

New Test time with n=30: 5907

New Test time with n=31: 5942

New Test time with n=32: 5984

New Test time with n=33: 6028

New Test time with n=34: 6077

New Test time with n=35: 6129

New Test time with n=36: 6185

New Test time with n=37: 6242

New Test time with n=38: 6304

New Test time with n=39: 6367

New Test time with n=40: 6433

New Test time with n=41: 6501

New Test time with n=42: 6570

New Test time with n=43: 6642

New Test time with n=44: 6715

New Test time with n=45: 6789

New Test time with n=46: 6865

New Test time with n=47: 6943

New Test time with n=48: 7021

New Test time with n=49: 7101

New Test time with n=50: 7182

New Test Method is better with 25 people in 1 group. 
For traditional method, we need 72275 times, but for new method we only need 5817 times, 8.05 percentage of traditional one.




