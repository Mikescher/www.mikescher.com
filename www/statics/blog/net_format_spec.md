Here my (growing) collection of C# format specifier, this is not a complete list but rather a collection of specifier I needed in the past:

###Short syntax summary

```csharp
"{0,5:000;0.#;0}"
```

```plain
{
0           // The index of the displayed object
,5          // A padding of 5
000;0.#;0   // The format string
}
```

```plain
000   // The format for positive numbers (min 3 places, fill missing with zeroes)
;
0.#   // The format for negative numbers (at least one digit before decimal point, maximum one after)
;
0     // The format for zeros (one digit -  a zero)
```

###Align right with leading spaces

```csharp
"{0,6}" // min-width: 6 character
```

###Digits after decimal point

```csharp
"{0:0.00}" // exactly 2 digits after decimal point
"{0:0.##}" // maximal 2 digits after decimal point
```

###Align positive & negative numbers with leading zeros

```csharp
/* integer: */
"{0:0000;-000}" // min-width: 4 character

/* float: */
"{0:0000.00;-000.00}" // min-width: 4 character + 2 decimal places
```

###Remove minus sign

```csharp
"{0:0;0}"
```

###Show thousand seperator

```csharp
"{0:#,0}" // only for integer
```

###Scale numbers

```csharp
"{0:#,#}"            // normal number
"{0:#,##0, kilo}"    // (number/1000) kilo
"{0:#,##0,, mill}"   // (number/1000/1000) million
"{0:#,##0,,, bill}"  // (number/1000/1000/1000) billion
```

> **see: ** [stackoverflow.com](http://stackoverflow.com/questions/11731996/string-format-numbers-thousands-123k-millions-123m-billions-123b)

###Right align currency

```csharp
"{0,10:#,##0.00}" // Right aligned & always 2 decimal places
```

> **see: ** [stackoverflow.com](http://stackoverflow.com/questions/7422625/right-align-currency-in-string-format)

###Align strings

```csharp
"{0,-10}" // Left aligned, min-width: 10 chars
"{0,10}"  // Right aligned, min-width: 10 chars
```

###Datetime formatting

```csharp
"s" // second
"m" // minute
"t" // AM/PM
"h" // hour (1-12)
"H" // hour (0-23)
"d" // day
"M" // month
"y" // year
"z" // timezone offset

"{0:D/M/yyyy}"            //  z.B.: 28/2/2013"
```

###Only show positive numbers

```csharp
"{0:#.#####;'';}"
```

###Add a prefix/suffix

```csharp
"{0:(0)}" // ( number )
"{0:_0_}" // _number_
```

###Format Hexadecimal

```csharp
"{0:X}"    // z.B.: 138D5
"{0:x}"    // z.B.: 138d5
"{0:X8}"   // z.B.: 000138D5
"0x{0:X8}" // z.B.: 0x000138D5
```

