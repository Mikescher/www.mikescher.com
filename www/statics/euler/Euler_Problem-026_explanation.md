To calculate the repeating-digit-count we use an algorithm based on the idea of a long division. Here on the example of `1/7`

| Position | Value         | Remainder     | Note                                   |
|----------|-------------- |---------------|----------------------------------------|
| 0        | 0,            | 10/7          | `10/7 = 1` **&** `(10%7)*10 = 30`      |
| 1        | 0,1           | 30/7          | `30/7 = 1` **&** `(30%7)*10 = 20`      |
| 2        | 0,13          | 20/7          | `20/7 = 1` **&** `(20%7)*10 = 60`      |
| 3        | 0,132         | 60/7          | `60/7 = 1` **&** `(60%7)*10 = 40`      |
| 4        | 0,1328        | 40/7          | `40/7 = 1` **&** `(40%7)*10 = 50`      |
| 5        | 0,13285       | 50/7          | `50/7 = 1` **&** `(50%7)*10 = 10`      |
| 6        | 0,132857      | 10/7          | **duplicate remainder -> loop closed** |

**=>** RepeatingDigitCount := `6 - 0` = `6`

We use a 1000-field "array" to remember every remainder we already had - as soon as we reach one that is already in use the digits start repeating itself.

For better understanding here the **FindRepeatingDigitCount(int divisor)** algorithm in pseudo-code:

```
int current = 1;
int position = 0;
while(true) {
	current = (current*10) % divisor;
	position++;
	
	if (grid[current] != 0) return position - grid[current];
	else grid[current] = position;
}
```