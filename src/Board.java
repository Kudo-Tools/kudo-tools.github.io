import javax.swing.JFrame;
import javax.swing.JPanel;
import java.awt.GridLayout;
import java.awt.Color;
import java.awt.Dimension;
/**
 * @author Teeds - Theo K
 */
public class Board {
    boolean computer_Turn = false;
    Box[][] boxes = new Box[3][3];
    boolean game_over = false;
    JFrame frame;
    JPanel body;
    public Board() {
        this.frame = new JFrame("Tic Tac Toe");
        this.frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        
        body = new JPanel();
        GridLayout grid = new GridLayout(3,3);
        grid.setHgap(5);
        grid.setVgap(5);
        body.setLayout(grid);
        body.setBackground(new Color(0,0,0));
        
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                boxes[x][y] = new Box(this, x, y);
                body.add(boxes[x][y]);
            }
        }

        this.frame.add(body);
        this.frame.setPreferredSize(new Dimension(500,500));
        this.frame.pack();
        this.frame.setVisible(true);
    }

    public boolean getTurn() {
        return computer_Turn;
    }

    public boolean getGameOver() {
        return game_over;
    }

    public void makeMove() {
        String winner = checkWin();
        if(winner != null) {
            System.out.println("Winner: " + winner);
        }
    }

    private String checkWin() {
        String[][] layout = new String[3][3];
        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                layout[x][y] = (boxes[x][y].getSelected()) ? 
                    ((boxes[x][y].getComputer()) ? "Computer" : "Human") : null;
            }
        }

        for(int x = 0; x < 3; x++) {
            if(layout[x][0] != null &&  layout[x][0] == layout[x][1] && layout[x][1] == layout[x][2]) {
                return layout[x][0];
            }
        }
        for(int y = 0; y < 3; y++) {
            if(layout[0][y] != null && layout[0][y] == layout[1][y] && layout[1][y] == layout[2][y]) {
                return layout[0][y];
            }
        }
        if(layout[0][0] != null) {
            if(layout[0][0] == layout[1][1] && layout[1][1] == layout[2][2]) {
                return layout[0][0];
            } else if (layout[2][0] == layout[1][1] && layout[1][1] == layout[0][2]) {
                return layout[1][1];
            }
        }
        return null;
    }

    // private String switchToString(boolean computer) {
    //     if(computer)
    //         return "Computer";
    //     return "Human";
    // }

    public void setTurn(boolean turn) {
        this.computer_Turn = turn;
    }
    
    public void newGame() {

    }
}