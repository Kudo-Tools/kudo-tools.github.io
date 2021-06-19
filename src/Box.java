import javax.swing.JPanel;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.BasicStroke;
import java.awt.Color;
import java.awt.event.MouseEvent;
import java.awt.event.MouseListener;
public class Box extends JPanel implements MouseListener{
    String occuptation;
    Board board;
    boolean selected = false;
    Color selected_color;
    int x, y;
    
    public Box(int x, int y) {
        this.x = x;
        this.y = y;
    }

    public Box(Board board, int x, int y) {
        this.board = board;
        this.x = x;
        this.y = y;
        addMouseListener(this);
    }

    protected void paintComponent(Graphics g) {
        super.paintComponent(g);
        Graphics2D graphics = (Graphics2D) g;
        if(selected_color != null) {
            graphics.setColor(selected_color);
            graphics.fillRect(0, 0, getWidth(), getHeight());
        } else {
            graphics.setColor(new Color(255,255,255));
        }
        graphics.setStroke(new BasicStroke(2.4f));
        graphics.drawRect(0,0,getWidth(), getHeight());
    }

    public int getXPosition() {
        return x;
    }

    public int getYPosition() {
        return y;
    }

    public boolean getSelected() {
        return selected;
    }

    public String getOccupation() {
        return occuptation;
    }

    public String getPlayer() {
        return occuptation;
    }

    public void setBackendSelected(boolean selected) {
        this.selected = selected;
    }

    public void setComputer() {
        this.occuptation = "Computer";
    }

    public void setHuman() {
        this.occuptation = "Human";
    }

    public void setComputerSelected() {
        this.occuptation = "Computer";
        selected_color = new Color(142,62,240);
        selected = true;
        this.board.setTurn(false);
        repaint();
    }

    @Override
    public void mouseClicked(MouseEvent e) {
        // System.out.println(selected);
        if(!selected && !board.getGameOver()) {
            selected_color = new Color(98,213,157);
            this.occuptation = "Human";
            
            this.board.setTurn(true);
            selected = true;
            repaint();
            this.board.makeMove();
        }
    }

    @Override
    public void mousePressed(MouseEvent e) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mouseReleased(MouseEvent e) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mouseEntered(MouseEvent e) {
        // TODO Auto-generated method stub
        
    }

    @Override
    public void mouseExited(MouseEvent e) {
        // TODO Auto-generated method stub
        
    }
}
