BefunExec is a fast Befunge-93 interpreter.

![BEFUNEXEC_MAINWINDOW](/data/programs/desc/BefunGen/01_Manuals/BefunExec_Main.png)

BefunExec can either be controlled over the menu or by keyboard shortcuts.
You can read about the shortcuts and the command line parameters in the console window of BefunExec.

##Program

In the center you can see the program, depending on your options highlighted or not.  
You can zoom in either with your mouse wheel or by dragging a selection box. With `Esc` can you go one zoom level back.
By pressing `R` can you reset the whole program and by pressing `Space` can you pause/un-pause it.  
While he program s paused you can do a single step by pressing `Left`  
You can also change the simulation speed with the shortcuts `1` to `5` and add breakpoints by clicking on a single command (breakpoints are displayed blue).

 > **Tip:**  
 > Access debug information like FPS and your current interpretation speed by holding `tab`

##Stack

On the left side is the current program stack, if you have enabled it you can see behind the numbers the ASCII representation of the number.

##In/Output

Every output is written into the output field and the console, you can also access all the output over the menu entry "show output".

For the input there is an input buffer in place. You can enter a series of chars in the input-box and press the input button.
Your text is then in the input buffer and the next time the program wants to read a character it will take it from this buffer.
If the buffer is empty the program will pause until there is a character in it which it can read.

When the programs reads a number on the other side will always pause the program and ask the user to enter a number.

##Settings

Over the menu you can change a few settings:

 - **Syntax Highlighting**: Choose your Syntax highlighting method
 - **Follow cursor**: Zoom in and follow the PC automatically around
 - **Show trail**: Show trail behind PC
 - **ASCII stack**: Show ASCII characters in stack display
 - **Skip NOP's**: Skip continuous White spaced
 - **Debug mode**: While in debug mode you will be warned of operations that would never occur in a BefunGen created program (wrap-around-edge, pop empty stack ...)

###Extended Syntax Highlighting

![BEFUNEXEC_ESH](/data/programs/desc/BefunGen/01_Manuals/BefunExec_ESH_example.png)

BefunExec can use BefunHighlight to highlight the program (= extended Syntax highlighting).  
It will automatically choose so if the program isn't too big and you haven't explicitly specified another highlighting method.
Be aware that when you run on top speed and BefunExec is getting slowed down a lot by BefunHighlight it will automatically change the highlighting method.
 
##Additional

###Capture GIF

![BEFUNEXEC_CAPTUREGIFDIALOG](/data/programs/desc/BefunGen/01_Manuals/BefunExec_CaptureGifDialog.png)

With the menu point "Capture GIF" you can create an animated .gif animation of your running program. 
You can set the amount of steps to capture and the animation delay between the steps. You can also set the final delay before the animation restarts.
There is also the "Automatic frame count" option, only use this if your program terminates in a reasonable amount of frames.