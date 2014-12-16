<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TBkHeaderContainer">
        <div class="header">
            <h1 class="backend-title">
                <div class="logo">
                </div>
                All Unit management console
            </h1>
            <div class="header-container">
                <xsl:apply-templates />
            </div>
            <div class="clear"/>
        </div>
    </xsl:template>
</xsl:stylesheet>
