There are only `N` kinds of numbers: 

- `0` - `20`: Get the length from a precomputed list
- `20` - `99`: Get the length of the first word from a precomputed list and the length of the second word (second digit) from the previous point
- `100` - `999`: Get the length of the first word from a precomputed list and the length of the second and third word (second digit) from the previous point
- `1000`: Get the hard coded value

*Note*: Interestingly this program operates completely on the stack - only the initializing method sets a few "constant fields" to per-definied values