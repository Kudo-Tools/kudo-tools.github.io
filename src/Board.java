import javax.swing.JFrame;
import javax.swing.JPanel;
import java.awt.GridLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.BorderLayout;
/**
 * @author Teeds - Theo K
 */
public class Board {
    boolean computer_Turn = false;
    Box[][] boxes = new Box[3][3];
    boolean game_over = false;
    JFrame frame;
    JPanel body;
    JPanel gameBody;
    public Board() {
        this.frame = new JFrame("Tic Tac Toe");
        this.frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        
        body = new JPanel();
        body.setLayout(new BorderLayout());
        body.setBackground(new Color(0,0,0));

        gameBody = new JPanel();
        GridLayout grid = new GridLayout(3,3);
        grid.setHgap(5);
        grid.setVgap(5);
        gameBody.setLayout(grid);
        gameBody.setBackground(new Color(255,255,255));
        
        body.add(gameBody, BorderLayout.CENTER);

        for(int x = 0; x < 3; x++) {
            for(int y = 0; y < 3; y++) {
                boxes[x][y] = new Box(this, x, y);
                gameBody.add(boxes[x][y]);
            }
        }

        this.frame.add(body);
        this.frame.setPreferredSize(new Dimension(500,500));
        this.frame.pack();
        this.frame.setVisible(true);
    }

    public Box[][] getBoxes() {
        return boxes;
    }

    public boolean getTurn() {
        return computer_Turn;
    }

    public boolean getGameOver() {
        return game_over;
    }

    public void makeMove() {
        String winner = new CheckWin().getWinner(boxes);
        if(winner != null) {
            System.out.println("Winner: " + winner);
        }
        if(computer_Turn) {
            System.out.println("-----------------------");
            
            Minimax result = new Minimax();
            int[] best = result.bestChoice(this);
            boxes[best[0]][best[1]].setComputerSelected();
            System.out.println("-------Done with Computer------");
            
        }
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