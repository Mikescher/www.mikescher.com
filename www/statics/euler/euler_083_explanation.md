Now, after two pseudo-pathfinding problems we finally get a real one.

The right solution would proably be to search online for dijkstras algorithm,
but I'm lazy and I kinda remember the essence - so I implement my own algorithm from what I remember about pathfinding :D.

The general idea is still the same - we generate a 80x80 grid where each cell contains the minimal distance to the node `[0,0]`.
At the end we just have to look at the value of `distance[79, 79]`.
Initially all distances are set to an absurdly high number.

Additionally we have a a 80x80 marker-grid where we mark cells either `UNKNOWN (#)`, `MARKED (0)` or `FINISHED (1)`.
Initially all cells are Unknown.

We start our algorithm by setting `distance[0, 0] = data[0, 0]` and `marker[0, 0] = MARKED`

Then we execute the main loop until all cells are marked with FINISHED,
in our main loop we do:

 - Search fo a MARKED cell
 - Calculate for all 4 directions the distance:
 - `distance = distance[x, y] + data[x+1, y]` *(or `x-1`, `y+1`, `y-1`, depending on the direction)*
 - If the calculated distance is less than the cached value (`distance[x+1, y]`) update the distance and set the updated cell to MARKED
 - Set our current cell to FINISHED (`marker[x, y] = FINISHED`)

Rinse and repeat until finished.