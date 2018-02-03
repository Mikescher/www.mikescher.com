An automatic solver for [Hexcells](http://www.matthewbrowngames.com/hexcells.html), [Hexcells Plus](http://www.matthewbrowngames.com/hexcellsplus.html) and [Hexcells Infinite](http://www.matthewbrowngames.com/hexcellsinfinite.html).  
The idea is to automatically parse the game state, find the next (valid) step and execute it.  
*(Rinse and Repeat until everything is solved)*

### [> Animation](https://gfycat.com/GrotesqueRecklessAcornbarnacle)

##Usage

 - Start HexCells Infinite *(should also work with the other Hexcell games)*
 - I recommend window-mode with 1440x900 resolution (for the OCR to work best)
 - Load a level
 - Start HexSolver
 - Press **Recapture**
 - If you want to completely solve the level press **Execute (All)**
 - Don't manually move your mouse until finished (press ESC to abort)
 - If you just want to see the next step press **Solve** (Can take around 5-10 seconds)

##Troubleshooting

 - HexSolver needs an minimum amount of orange cells to recognize the layout
 - HexSolver only works when all cells are in an uniform grid (click **Calculate** to see the grid)
 - Only click Recapture when the fading in effect is finished - otherwise no cells can be recognized
 - If you find the (uncommon) case of two row-hint in one cell, HexSolver will fail *<sup>(sorry)</sup>*
 - If HexSolver fails to solve a configuration or the OCR module fails, please send me an <u>full-resolution</u> screenshot of the game.

##Features

 - Automatic finding of game window and capturing of its graphical output
 - Dynamically finding the hexagon layout
 - With an custom crafted OCR module recognition of the cell values
 - 3-Step solving of the current configuration (tested on the original levels and many of the generated ones)
 - Finding the optimal execution path by solving the corresponding [TSP](https://en.wikipedia.org/wiki/Travelling_salesman_problem)
 - Automatic execution by programmatically moving the mouse
 - Saving the current (captured) state as an [*.hexcells](https://github.com/BlaXpirit/sixcells) file
