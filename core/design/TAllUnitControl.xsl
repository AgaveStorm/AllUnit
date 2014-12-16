<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TAllUnitControl">
        <html>
            <head>
                <xsl:apply-templates select="TAuHeadControl"/>
            </head>
            <body>
                <xsl:apply-templates select="TAuManageContainer"/>
                <xsl:apply-templates select="TAuUnitsContainer"/>
                <xsl:apply-templates select="TAuFooterControl"/>
                <xsl:apply-templates select="TDebugControl"/>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
