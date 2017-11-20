This one is really great - I came up with an O(log n) algorithm (crazy fast) for determining the n-th digit.  
First I tested it in LinqPad, so here the C# code for the algorithm:

```csharp
public int digitAt(int pos) {
    int digitcount = 1;
    int digitvalue = 1;
    
    // Get DigitCount of current number
    while(pos > digitvalue * 9 * digitcount) {
        pos -= digitvalue * 9 * digitcount;
        digitcount++;
        digitvalue *= 10;
    }
    
    // current number and digit-position in number
    int value = digitvalue + (pos - 1)/digitcount;
    int digit = digitcount - (pos - 1)%digitcount - 1;
    
    return getInternalDigit(value, digit);
}

public int getInternalDigit(int value, int digit) {
    return (value / (int)Math.Pow(10, digit)) % 10;
}
```