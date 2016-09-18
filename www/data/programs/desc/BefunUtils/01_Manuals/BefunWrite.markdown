BefunWrite is an IDE to write and compile TextFunge, once started you will see the main window:

![](https://raw.githubusercontent.com/Mikescher/BefunUtils/master/README-FILES/BefunWrite_Main.png)

You can write your code in the center and see a summary of current constants/variables/methods on the right side. 
On the bottom site you can also expand the tabs `Output` and `ErrorList`.

In the code section you can see an example program (a simple hello world), feel free to edit this example or delete it completely.
You can safe your code in the menu or by pressing `STRG+S`. 3 different files will be created:

 - `projectname.tfp`  : The project file, it contains settings and the path to the other files
 - `projectname.tf`   : The actual source-code
 - `projectname.tfdv` : The initial display value (or empty if not defined)

If you want to set an initial display value (see the topic `TextFunge` for more information) you can modify the tab `Display` beside the tab `code`.
To build the project simply choose a  build configuration (Debug and Release are the defaults) and click `Build`.
The builded Befunge files will end up in the sub-folder `projectname\configname`.  
To test the program you can also choose run, this will build the project and then open it in BefunExec.

##Build configurations

With the build configurations dialog you can modify the build process

![BEFUNWRITE_SETTINGS](/data/programs/desc/BefunGen/01_Manuals/BefunWrite_Settings.png)

> **Note:**  
>
> - **PC** is the *Program Counter*, the current position in the program  
> - **NOP-cells** are the unused parts of the program, they are neither variable space, nor commands.  
> The PC will enter them and they should never be evaluated.

###General

> General BefunWrite Settings

 - **Name**
 
###Execution
 
####BefunExec Settings
 
 - **Debugging Enabled**: Enable debugging options (warnings on unexpected behaviours)
 - **Start Paused**: Starts the program non-running
 - **Syntax highlighting**: Sets the preferred syntax highlighting method
 - **Show chars in stack**: Show the ASCII chars in the stack
 - **Follow PC**: Start with follow mode enabled
 - **Skip Whitespace**: Skip continuous white-spaces 
 - **Initial speed**: Sets (the index) of the initial interpretation speed
 - **Speed[x]**: The delay between cycles on speed level *x*
 - **Show Tail**: Show a fading tail behind the actual PC
 - **Lifetime Tail**: The time (in ms) until the tail has faded away
 - **Start zoomed in on display**: Set the initial zoom fitting for the display
 
###Code Generation
 
####BefunGen Settings
 
  - **Number literal representation**: The used algorithm for presenting number literals
  - **Optimize double string-mode**: Try to combine two adjacent `"` together
  - **Set NOP to special char**: Set NOP cells to a special character
  - **Custom NOP char**: The special character for NOP cells (if used)
  - **Horizontal compression**: Try to horizontally compress the program
  - **Vertical compression**: Try to vertically compress the program
  - **Minimum VarDecl. width**: The minimum width of a declaration block, increase this if your initialization-blocks grow in height.
  - **Default VarDecl char**: The initial char (before initialization) of variable fields
  - **Default TempDecl/TempResult char**: The initial char (before use) of temporary fields
  - **Safe boolean cast**: When hard-casting a variable to boolean it will result in either a **1** or a **0**
  - **Default local int/char/bool var value**: The initial value of a local variable *(should stay default)*
  - **Initial disp char**: The initial character of the display fields
  - **Display border value**: The character of the border around the display
  - **Display border thickness**: The thickness of the border around the display
  - **Prevent Display overflow**: When accessing coordinates outside of the display wrap around the edges.
  - **Optimize static Expr**: Try to compile-time interpret simple expressions (4 * 4 + 4  ==> 20)
  - **Remove unused methods**: Don't include methods that get never called

 > **Warning !**
 > If **Prevent Display overflow** is not set you can write into your own program and cause *really* strange behaviour.  
 > If you choose this path you have to prevent an out-of-bounds display access for yourself.

 Be aware that it is wise to leave most code generation settings on their default values.  
 For the most cases only the settings **Set NOP to special char**, **Safe boolean cast** and **Prevent Display overflow** should be interesting.