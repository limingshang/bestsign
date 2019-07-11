# 上上签V3版本
    本项目需要依赖：phpWord PhpOffice\PhpWord
    其他请自行考虑使用
    安装word转换pdf参考
    https://blog.csdn.net/diyiday/article/details/79852923
### 版本
    使用libreoffice6.1.6
### 下载源文件：
    wget http://mirrors.ustc.edu.cn/tdf/libreoffice/stable/6.1.6/rpm/x86_64/LibreOffice_6.1.6_Linux_x86-64_rpm.tar.gz
    wget http://mirrors.ustc.edu.cn/tdf/libreoffice/stable/6.1.6/rpm/x86_64/LibreOffice_6.1.6_Linux_x86-64_rpm_sdk.tar.gz
    wget http://mirrors.ustc.edu.cn/tdf/libreoffice/stable/6.1.6/rpm/x86_64/LibreOffice_6.1.6_Linux_x86-64_rpm_langpack_zh-CN.tar.gz
### 解压文件
    tar -zxvf LibreOffice_6.1.6_Linux_x86-64_rpm.tar.gz
    tar -zxvf LibreOffice_6.1.6_Linux_x86-64_rpm_sdk.tar.gz
    tar -zxvf LibreOffice_6.1.6_Linux_x86-64_rpm_langpack_zh-CN.tar.gz
### 执行安装
    参考文档：https://blog.csdn.net/diyiday/article/details/79852923
# 注意安装的版本为6.1.6     文档中的都是6.0的
    
### 转换需要将字体都增加至服务器
    
    
### 测试需要转换的文件
    生成pdf命令libreoffice6.1 --invisible --convert-to pdf:writer_pdf_Export a.docx --outdir PDF