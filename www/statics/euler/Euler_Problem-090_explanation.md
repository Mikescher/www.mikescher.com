We have nine square numbers that need to be represented.
For each number we can either use dice one for the first digit and dice two for the second or the other way around. Together there are `2^9 (=512)` possibilities.
In our program we iterate through them all (a simple binary counter at program position [9,0]).

In each turn we remember which numbers would need to be written on the first dice and which on the second one (we have two boolean arrays at [4,1] and [4,2]). If one dice needs more than six numbers on it we can directly throw this combination away and go on with the next number in our binary counter.

It's important that in this phase we have no nines. Every nine is replaced with a six (so we use `3*3 = 09` and `7*7 = 46`) The nines are later taken into account.

Now most of the time one or both dices have less than six digits on it (sometimes even only four).
We iterate now through all possible combinations of six digits with our found set as a basis. (So if one dice has 5 digits and the other one 4 we generate an additional 150 combinations (`5*5*6`).

Then in the last step we look at each dice and see if it contains a six and no nine. If this is the case we generate another combination where the six and the nine is exchanged. (Because we do this for each dice individually we can for each given combination possibly generate four new ones *(original, D1 exchanged, D2 exchanged, both exchanged)*).

Now we have every possible combinations that fits our initial condition. To weed out all the duplicates we generate a hash from the combination and remember previously found values in an 80x16 big hashmap (originally I had the map way bigger, but after my first successful run I could shrink the size to a more fitting value).

The hash is simply the binary representation of **D1** and **D2** concatenated (one for "has this digit", zero for "does not have this digit").
Because the order of the dices is irrelevant in our result we ignore it also in our hash and always use the dice with the smaller hash value as the lower bits of the total hash (this way `HASH(D1,D2) == HASH(D2,D1)`).

One problem of writing this program (except the metric fuck-ton of code all this needs, seriously I filled a 80x30 grid only with logic, there is more raw code than space for the 1280-elements hashmap) were the filling methods.

In my C# test program I had three functions:

 - **PadLeft** fills the left digit up to six digits with all possible values
 - **PadRight** fills the right digit up to six digits with all possible values
 - **PadNine** exchanges `6` with `9` in the left and right digit to generate all possible combinations
 - **Output** Test if a is already in the hashmap, if not increments the counter 

Now the function PadLeft() calls PadRight() which calls PadNine(), which calls Output(). Each at three to four different places.
So in my befunge program I needed to do the same thing every sane procedural language does:
Remember the back jump address, so after PadNine() is called we know where in PadRight() we have to continue the program flow.

Unfortunately this is in befunge not really good to write and leads to a lot of boilerplate code, but it's still better than writing the Output function twenty-seven times in different places.

A last note: This is the first program where I put the big data structures below the actual code. It's nice to have all the program logic at the top of the file, but every time I address something down there the constants for the Y value take more space. This is also the reason my variables are always in the top left corner, there I can address them with only three commands (`xyg` bzw `xyp`) as long as `x` and `y` are below ten.
So I think it's not too bad to have the data below the code but for the future I will keep my old organization.