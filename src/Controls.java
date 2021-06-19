import javax.swing.JButton;
import javax.swing.JPanel;
import java.awt.BorderLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseAdapter;
public class Controls extends JPanel{
    Board board;
    public Controls(Board board) {
        this.board = board;
        setLayout(new BorderLayout());
        add(createRefreshButton(), BorderLayout.SOUTH);
    }
    private JButton createRefreshButton() {
        JButton button = new JButton("New Game");
        button.addMouseListener(new MouseAdapter() {
            public void mouseClicked(MouseEvent e) {
                
            }
        });
        return button;
    }
}
