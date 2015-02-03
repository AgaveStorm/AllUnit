<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TWlkNavigateAuManage">
        <div class="welcome-box">
            <div class="inner">
                <div class="tnx">Almost done!</div>
                <div class="content">
                    Navigate to management console and activate all units you need. 
                </div>
                <a class="button" href="{//siteurl}/au-manage/units">Manage Units</a>
            </div>
        </div>
    </xsl:template>
</xsl:stylesheet>
