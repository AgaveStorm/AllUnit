<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" encoding="utf-8" indent="no"/>
    <xsl:template match="TUnitListControl">
        <h3>Project units</h3>
        <xsl:call-template name="unitList">
            <xsl:with-param name="level" select="'3'"/>
        </xsl:call-template>
        <h3>Community units</h3>
        <xsl:call-template name="unitList">
            <xsl:with-param name="level" select="'2'"/>
        </xsl:call-template>
        <h3>Core units</h3>
        <xsl:call-template name="unitList">
            <xsl:with-param name="level" select="'1'"/>
        </xsl:call-template>
    </xsl:template>
    <xsl:include href="unitList.xsl"/>
</xsl:stylesheet>
