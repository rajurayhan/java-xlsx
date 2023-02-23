import lombok.extern.slf4j.Slf4j;
import org.apache.poi.hssf.usermodel.HSSFWorkbook;
import org.apache.poi.ss.usermodel.*;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.util.Iterator;


public class Main {
    final static void log(String msg) {
        System.out.println(msg);
    }

    public static void main(String[] args) {
        try {
            String filePath = "/home/raju/Workshop/Docs/demo.xlsx";
            final FileInputStream fis = new FileInputStream(filePath);
            Workbook workbook = null;
            if(filePath.toLowerCase().endsWith("xlsx")){
                workbook = new XSSFWorkbook(fis);
            }else if(filePath.toLowerCase().endsWith("xls")){
                workbook = new HSSFWorkbook(fis);
            }
            Sheet sheetMain = workbook.getSheet("main");
            Iterator<Row> iterator = sheetMain.iterator();
            while (iterator.hasNext()) {
                Row currentRow = iterator.next();
                Iterator<Cell> cellIterator = currentRow.iterator();
                while (cellIterator.hasNext()) {
                    Cell currentCell = cellIterator.next();
                    log(currentCell.getCellType().toString());
                    if (currentCell.getCellType().equals(CellType.STRING)) {
                        log(currentCell.getStringCellValue() + "--");
                    } else if (currentCell.getCellType().equals(CellType.NUMERIC)) {
                        log(currentCell.getNumericCellValue() + "--");
                    }
                }
            }

        } catch (Exception e) {
            log(e.toString());
//            git remote set-url git@github.com:rajurayhan/java-xlsx.git
        }
    }
}
