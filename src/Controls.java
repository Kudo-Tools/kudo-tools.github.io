import javax.swing.JButton;
import javax.swing.JPanel;
import javax.swing.JTextArea;

import java.awt.BorderLayout;
import java.awt.event.MouseEvent;
import java.awt.event.MouseAdapter;
public class Controls extends JPanel{
    Board board;
    JTextArea logs = new JTextArea();
    public Controls(Board board) {
        this.board = board;
        logs.setEditable(false);
        setLayout(new BorderLayout());
        add(logs, BorderLayout.NORTH);
        add(createRefreshButton(), BorderLayout.SOUTH);
    }
    private JButton createRefreshButton() {
        JButton button = new JButton("New Game");
        button.addMouseListener(new MouseAdapter() {
            public void mouseClicked(MouseEvent e) {
                board.reset();
            }
        });
        return button;
    }
    public void addLog(String message) {
        this.logs.append(message+"\n");
    }
}
